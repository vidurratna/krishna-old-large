<?php

namespace App;

use App\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

class Role extends Model {

    use UsesUuid;

    protected $table = 'roles';

    protected $fillable = [
        'name', 'ident', 'description', 'active', 'level',
    ];

    protected $casts = [
        'active' => 'bool',
        'level' => 'int',
    ];

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    // public function users() {
    //     return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    // }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role_chapter')->withPivot('user_id','role_id'); 
        //'user_role_chapter', 'user_id', 'role_id', 'chapter_id'
    }

    public function usersWithChapter(){
        return $this->belongsToMany(User::class, 'user_role_chapter')->withPivot('user_id','role_id','chapter_id'); 
    }

    public static function allRoles()
    {
        return $roles = app(Pipeline::class)
                    ->send(Role::query())
                    ->through([
                        \App\QueryFilters\Active::class,
                        \App\QueryFilters\Sort::class,
                    ])
                    ->thenReturn()
                    ->paginate(15);
    }
}