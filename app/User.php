<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function avatar() : string
    {
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->email ) ) )  . "&s=" . 45 . "&d=mm";
    }

    /**
     * @param Topic $topic
     * @return bool
     */
    public function onwsTopic(Topic $topic) : bool
    {
        return $this->id === $topic->user->id;
    }
}
