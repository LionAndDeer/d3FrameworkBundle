<?php
/** @noinspection DuplicatedCode */

/** @noinspection PhpStatementHasEmptyBodyInspection */

namespace Liondeer\Framework\Security;

use App\Security\User;
use App\Security\UserProvider;
use Liondeer\Framework\Exception\LiondeerD3FrameworkException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class D3ecmAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private UserProvider $userProvider,
        private ParameterBagInterface $params
    ) {
    }

    public function supports(Request $request): bool
    {
        if (
            $request->headers->has('X-Dv-Caller')
//            $request->headers->has('x-dv-tenant-id')
//            && $request->headers->has('x-dv-baseuri')
//            && $request->headers->has('x-dv-sig-1')
        ) {
            return true;
        }

        return false;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): RedirectResponse
    {
//        $data = [
//            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
//
//            // or to translate this message
//            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
//        ];

        return new RedirectResponse($request->headers->get("x-dv-baseuri"));
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
        $credentials = [
            'd3TenantId' => $request->headers->get('x-dv-tenant-id'),
            'd3BaseUri' => $request->headers->get('x-dv-baseuri'),
            'd3Signature' => $request->headers->get('x-dv-sig-1'),
            'authSessionId' => $request->cookies->get('AuthSessionId')
        ];

        if($request->headers->has('authorization')) {
            $credentials['authSessionId'] = explode(' ', $request->headers->get('authorization'))[1];
        }

        if(!$credentials['authSessionId']) {
            throw new UserNotFoundException();
        }

        $user = $this->userProvider->loadUserFromD3($credentials);

        return new Passport(
            new UserBadge($user->getUserIdentifier(), function() use ($user) {
                return $user;
            }),
            new CustomCredentials(function ($customCredentials, User $user) {
                $private = base64_decode($this->params->get('d3_app_secret'));
                $sha = base64_encode(
                    hash_hmac('sha256', $customCredentials['d3BaseUri'].$customCredentials['d3TenantId'], $private, true)
                );
                if (
                    $user->getTenantId() === $customCredentials['d3TenantId']
                    && $sha === $customCredentials['d3Signature']
                ) {
                    return true;
                }

                return false;
            }, $credentials)
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // TODO: Implement onAuthenticationSuccess() method.
        return null;
    }
}
