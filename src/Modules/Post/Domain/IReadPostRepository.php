<?php declare(strict_types=1);

namespace Modules\Post\Domain;

use Modules\Post\Domain\Post;
use Modules\Shared\ValueObjects\Id;

interface IReadPostRepository
{
    public function findById(Id $id): Post;
}
