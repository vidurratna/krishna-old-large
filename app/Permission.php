<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'name', 'ident', 'description', 'active',
    ];

    protected $casts = [
        'active' => 'bool',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    }
}
