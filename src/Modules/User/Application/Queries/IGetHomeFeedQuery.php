<?php declare(strict_types=1);

namespace Modules\User\Application\Queries;

use Modules\Shared\ValueObjects\Id;

interface IGetHomeFeedQuery
{
    /**@return PostDto|SharedPostDto[] */
    public function ask(Id $userId, int $batch): array;
}
