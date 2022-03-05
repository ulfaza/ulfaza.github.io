<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primarykey = 'id';

    protected $fillable = [
        'nama', 'username', 'foto', 'role', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const ADMIN_TYPE = 'admin';
    const USERS_TYPE = 'guru';

    public function isAdmin() {
        return $this->role === self::ADMIN_TYPE;
    }

    public function isUser() {
        return $this->role === self::USERS_TYPE;
    }

    public function uji_kh()
    {
        return $this->hasMany(\App\UjiKh::class);
    }
}
