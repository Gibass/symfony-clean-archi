<?php

namespace App\Infrastructure\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AccountNotVerifiedAuthException extends AuthenticationException
{
}
