<?php

namespace App;

use App\Concerns\UsesUuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pipeline\Pipeline;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'email', 'password', 'first_name', 'last_name', 'phone', "date_of_birth"
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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role_chapter')->withPivot('user_id','chapter_id'); 
        //'user_role_chapter', 'user_id', 'role_id', 'chapter_id'
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    public function address()
    {
        return $this->morphToMany('App\Address', 'addressable');
    }

    public function chapters()
    {
        return $this->belongsToMany(Chapter::class, 'user_role_chapter')->withPivot('user_id','chapter_id','role_id'); 
        //'user_role_chapter', 'user_id', 'role_id', 'chapter_id'
    }

    public static function allUsers()
    {
        return $users = app(Pipeline::class)
                    ->send(User::query())
                    ->through([
                        \App\QueryFilters\Sort::class,
                        \App\QueryFilters\Chapter::class,
                    ])
                    ->thenReturn()
                    ->paginate(15);
    }
}
