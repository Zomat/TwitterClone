<?php declare(strict_types=1);

namespace Modules\User\Domain;

use Exception;

class CannotFollowYourselfException extends Exception
{
    protected $message = 'You cannot follow yourself!';
}
