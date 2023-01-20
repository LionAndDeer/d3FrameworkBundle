<?php
/** @noinspection DuplicatedCode */

namespace Liondeer\Framework\Security;

use App\Security\User;
use JetBrains\PhpStorm\ArrayShape;
use Liondeer\Framework\IdentityProvider\IdentityProviderUserService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class InterAppD3ecmAuthenticator extends AbstractGuardAuthenticator
{
    public function __construct(
        private ParameterBagInterface $params,
        private IdentityProviderUserService $identityProviderService
    ) {
    }

    public function supports(Request $request): bool
    {
        if (
            $request->headers->has('x-dv-tenant-id')
            && $request->headers->has('x-dv-baseuri')
            && $request->headers->has('x-dv-sig-1')
        ) {
            return true;
        }

        return false;
    }

    #[ArrayShape([
        'd3TenantId' => "null|string",
        'd3BaseUri' => "null|string",
        'd3Signature' => "null|string",
        'authSession' => "null|string"
    ])]
    public function getCredentials(
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
            'authSession' => $authSession
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
            && $sha === $signature
        ) {
            return true;
        }

        return false;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
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

    /**
     * Called when authentication is needed, but it's not sent
     *
     * @param Request $request
     * @param AuthenticationException|null $authException
     *
     * @return JsonResponse
     */
    public function start(Request $request, AuthenticationException $authException = null): JsonResponse
    {
        $data = [
            // you might translate this message
            'message' => 'Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }
}
