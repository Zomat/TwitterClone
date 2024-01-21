<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    use HasFactory;

    protected $table = 'follows';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id', 'follower_id', 'followed_id', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'follower_id', 'id');
    }

    public function userFollowedBy()
    {
        return $this->belongsTo(User::class, 'followed_id', 'id');
    }
}
