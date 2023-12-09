<?php declare(strict_types=1);

namespace Modules\Post\Domain;

use Exception;

class PostAlreadyLikedException extends Exception
{
    protected $message = 'Post has already been liked.';
}
