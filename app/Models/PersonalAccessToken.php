<?php declare(strict_types=1);

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as BasePersonalAccessToken;

class PersonalAccessToken extends BasePersonalAccessToken
{
    public function tokenable()
    {
        return $this->morphTo('tokenable', "tokenable_type", "tokenable_id");
    }
}
