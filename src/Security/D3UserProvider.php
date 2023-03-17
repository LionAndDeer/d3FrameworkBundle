<?php

namespace Liondeer\Framework\Security;

use App\Security\UserHelper;
use App\Security\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/** @codeCoverageIgnore */
class D3UserProvider implements UserProviderInterface
{
    public function __construct(
        private UserHelper $userHelper
    )
    {

    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        return $user;
        // Return a User object after making sure its data is "fresh".
        // Or throw a UsernameNotFoundException if the user no longer exists.
        //throw new Exception('TODO: fill in refreshUser() inside '.__FILE__);
    }

    /**
     * Tells Symfony to use this provider for this User class.
     */
    public function supportsClass($class): bool
    {
        return User::class === $class;
    }


    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $request = Request::createFromGlobals();
        $credentials = [
            'd3TenantId' => $request->headers->get('x-dv-tenant-id'),
            'd3BaseUri' => $request->headers->get('x-dv-baseuri'),
            'd3Signature' => $request->headers->get('x-dv-sig-1'),
            'authSessionId' => $request->cookies->get('AuthSessionId')
        ];
        return $this->userHelper->getCurrentUser($identifier, $credentials);
    }
}