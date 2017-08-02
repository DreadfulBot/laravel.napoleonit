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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function can($permission, $id) {
        $perm = explode('.', $permission);

        // if error or not match pattern object.action
        if(count($perm) == 0 || count($perm) < 2)
            return false;

        $action = end($perm);
        $object_root = $perm[0];

        switch ($object_root) {
            case 'category':
                switch ($action) {
                    case 'list':
                        // only admins
                        break;
                    case 'view';
                        // only admins and users
                        break;
                    default:
                        return false;
                }
                break;
            case 'article':
                switch ($action) {
                    case 'list':
                        // only admins
                        break;
                    case 'view':
                        // only admins and users
                        break;
                    default:
                        return false;
                }
                break;
            case 'user':
                switch ($action) {
                    case 'list':
                        // only admins
                        break;
                    case 'view':
                        // only admins
                        break;
                    default:
                        return false;
                }
        }
        return false;
    }
}
