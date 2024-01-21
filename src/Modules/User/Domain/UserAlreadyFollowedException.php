<?php declare(strict_types=1);

namespace Modules\User\Domain;

use Exception;

class UserAlreadyFollowedException extends Exception
{
    protected $message = 'User is already followed.';
}
