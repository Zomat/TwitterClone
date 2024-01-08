<?php declare(strict_types=1);

namespace Modules\Post\Domain;

use Modules\Post\Domain\Post;
use Modules\Shared\Repositories\IDatabaseTransactions;

interface IWritePostRepository extends IDatabaseTransactions
{
    public function create(Post $post): void;

    public function update(Post $post): void;

    public function share(Share $share): void;
}
