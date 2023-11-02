<?php declare(strict_types=1);

namespace Modules\Shared\Mappers;

use Illuminate\Database\Eloquent\Model;
use Modules\Shared\Entities\BaseEntity;

interface IMapper
{
    public static function toEntity(Model $model): BaseEntity;

    public static function toModel(BaseEntity $entity): Model;
}
