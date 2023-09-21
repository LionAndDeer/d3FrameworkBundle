<?php
/** @noinspection DuplicatedCode */

/** @noinspection PhpStatementHasEmptyBodyInspection */

namespace Liondeer\Framework\Security;

use Liondeer\Framework\Exception\LiondeerD3FrameworkException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Exception;

class D3UserAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private D3UserProvider        $userProvider,
        private ParameterBagInterface $params
    ) {
    }

    public function supports(Request $request): bool
    {
        return true;
    }

    /**
     * @param Request $request
     *
     * @return Passport
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws LiondeerD3FrameworkException
     * @throws TransportExceptionInterface
     */
    public function authenticate(Request $request): Passport
    {
        try {
            $credentials = $this->getCredentials($request);
            if ($request->headers->has('authorization')) {
                $credentials['authSessionId'] = explode(' ', $request->headers->get('authorization'))[1];
            }

            if (!isset($credentials['authSessionId'])) {
                throw new AuthenticationException();
            }

            $user = $this->userProvider->loadUserByIdentifier($credentials['authSessionId']);
            $credentialsValid = $this->checkCredentials($credentials, $user);
        } catch (Exception $exception) {
            throw new AuthenticationException();
        }

        if (!$credentialsValid) {
            throw new AuthenticationException();
        }

        return new SelfValidatingPassport(
            new UserBadge($user->getUserIdentifier(), function() use ($user) {
                return $user;
            }),
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // TODO: Implement onAuthenticationSuccess() method.
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        if (empty($request->headers->get("x-dv-baseuri"))) {
            $data = [
                'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

                // or to translate this message
                // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
            ];

            return new JsonResponse($data, Response::HTTP_FORBIDDEN);
        }
        return new RedirectResponse($request->headers->get("x-dv-baseuri"));
    }

    #[ArrayShape([
        'd3TenantId' => "null|string",
        'd3BaseUri' => "null|string",
        'd3Signature' => "null|string",
        'authSession' => "null|string"
    ])]
    private function getCredentials(Request $request    ): array {
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

    public function checkCredentials($credentials, UserInterface $user): bool {
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
}
