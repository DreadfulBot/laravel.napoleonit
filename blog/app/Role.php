<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['id', 'role', 'created_at', 'updated_at'];

    public function user() {
        return $this->belongsToMany(Role::class, 'user_role', 'role_id', 'id');
    }

    public function hasAccess(array $permissions) {
        foreach ($permissions as $permission) {
            if($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    protected function hasPermission(string $permission) {
        $permissions = json_decode($this->permissions, true);
        return $permissions[$permission]??false;
    }
}
