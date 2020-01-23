<?php

namespace App;

use App\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

class Permission extends Model
{
    use UsesUuid;

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


    public static function allPermissions()
    {
        return $permissions = app(Pipeline::class)
                    ->send(Permission::query())
                    ->through([
                        \App\QueryFilters\Active::class,
                        \App\QueryFilters\Sort::class,
                    ])
                    ->thenReturn()
                    ->paginate(15);
    }

}
