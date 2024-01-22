<?php declare(strict_types=1);

namespace Modules\Post\Application\Queries;

use Modules\Post\Application\Queries\Results\PostDto;
use Modules\Shared\ValueObjects\Id;

interface IGetPostQuery
{
    public function ask(Id $id): ?PostDto;
}
