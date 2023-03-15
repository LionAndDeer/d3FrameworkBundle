<?php

namespace Liondeer\Framework\Security;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserHelperInterface
{
    public function getCurrentUser(string $bearerToken, array $credentials): UserInterface;
}