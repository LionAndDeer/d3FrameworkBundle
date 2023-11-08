<?php
/** @noinspection DuplicatedCode */

namespace Liondeer\Framework\Security;

use App\Security\User;
use App\Security\UserHelper;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class InterAppAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        protected ParameterBagInterface $params,
        protected UserHelper $identityProviderService,
        protected InterAppProvider    $interAppProvider,
    ) {
    }

    public function authenticate(Request $request): Passport
    {
        try {
            $credentials = $this->getCredentials($request);

            if (false === $this->checkTenantManager->isTenantValid($credentials['d3TenantId'])) {
                throw new AuthenticationException();
            }

            if(!isset($credentials['authSessionId'])) {
                throw new AuthenticationException();
            }

            $interAppUser = $this->interAppProvider->loadUserByIdentifier($credentials['authSessionId']);
            $credentialsValid = $this->checkCredentials($credentials, $interAppUser);
        } catch (Exception $exception) {
            throw new AuthenticationException();
        }

        if (!$credentialsValid) {
            throw new AuthenticationException();
        }
        return new SelfValidatingPassport(
            new UserBadge($credentials['authSessionId']),
        );
    }

    public function supports(Request $request): bool
    {
        return true;
    }

    #[ArrayShape([
        'd3TenantId' => "null|string",
        'd3BaseUri' => "null|string",
        'd3Signature' => "null|string",
        'authSession' => "null|string"
    ])]
    protected function getCredentials(
        Request $request
    ): array {
        $authSession = '';

        if (!empty($request->headers->get('authorization'))) {
            $authSession = explode(' ', $request->headers->get('authorization'))[1];
        }

        return [
            'd3TenantId' => $request->headers->get('x-dv-tenant-id'),
            'd3BaseUri' => $request->headers->get('x-dv-baseuri'),
            'd3Signature' => $request->headers->get('x-dv-sig-1'),
            'authSessionId' => $authSession
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider): UserInterface|User|null
    {
        $tenant = $credentials['d3TenantId'];

        if (null === $tenant) {
            return null;
        }

        $user = new User();
        if (null != $credentials['authSession']) {
            $user = $this->identityProviderService->getCurrentUser($credentials['authSession'], $credentials);
        } else {
            $user->createDummyUser($credentials['d3BaseUri'], $tenant);
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        $tenant = $credentials['d3TenantId'];
        $baseuri = $credentials['d3BaseUri'];
        $signature = $credentials['d3Signature'];
        $private = base64_decode($this->params->get("d3_app_secret"));

        $sha = base64_encode(hash_hmac('sha256', $baseuri . $tenant, $private, true));

        /** @var User $user */
        if (
            $user->getTenantId() === $tenant
            && hash_equals($sha, $signature)
        ) {
            return true;
        }

        return false;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }
}
