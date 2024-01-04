<?php declare(strict_types=1);

namespace Modules\Post\Domain;

use Modules\Post\Domain\Post;

interface IWritePostRepository
{
    public function create(Post $post): void;

    public function update(Post $post): void;

    public function share(Share $share): void;
}
