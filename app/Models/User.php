<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Target;
use App\Models\UserToken;
use App\Models\Topic;
use App\Models\TargetTag;

/**
 * type = 0 (email), 1 (facebook), 2(google)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function targets()
    {
        return $this->hasMany(Target::class, 'user_id', 'id');
    }

    public function user_token()
    {
        return $this->hasOne(UserToken::class, 'user_id', 'id');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class, 'user_id', 'id');
    }

    public function targetTags()
    {
        return $this->hasMany(TargetTag::class, 'user_id', 'id');
    }

    public function habits()
    {
        return $this->hasMany(Habit::class);
    }
}
