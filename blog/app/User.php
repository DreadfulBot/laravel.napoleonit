<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'remember_token', 'api_token'
//    ];

    public function role() {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }

    public function article() {
        return $this->hasMany(Article::class, 'user_id', 'id');
    }

    public function hasAccess(array $permissions)
    {
        $roles = $this->role()->get();
        foreach ($roles as $role) {
            /* @var \App\Role $role */
            if ($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }
}
