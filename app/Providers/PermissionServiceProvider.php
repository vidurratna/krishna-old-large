<?php

namespace App\Providers;

use App\Permission;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $cacheKey = 'permissions';
        $permissions = Cache::get($cacheKey);

        if (! $permissions) {
            $permissions = Permission::pluck('ident');
            Cache::put($cacheKey, $permissions->toArray());
        } else {
            $permissions = collect($permissions);
        }

        //Cache::forget('permissions') once you add new perms

        $permissions->each(function(string $ident) {
            Gate::define($ident, function (User $user, $chapter) use($ident) {
                $cacheKey = 'user.' . $user->id . '.permissions';
                $userPermissions = Cache::get($cacheKey);

                if(! $userPermissions) {
                    $userClosure = function ($query) use ($user, $chapter) {
                        $query->where('users.id', '=', $user->id)
                              ->where('chapter_id', '=', $chapter->id)
                              ;
                    };

                    $userPermissions = Permission::query()
                                            ->whereHas('roles', function ($query) use($userClosure){
                                                $query->where('active', '=', 1)
                                                        ->whereHas('users', $userClosure);
                                            })
                                            //->orWhereHas('users', $userClosure)
                                            //->groupBy('permissions.id')
                                            //->where('active', '=', 1)
                                            ->pluck('ident');

                    Cache::put($cacheKey, $userPermissions->toArray());
                } else {
                    $userPermissions = collect($userPermissions);
                } 

                // $error = \Illuminate\Validation\ValidationException::withMessages([
                //     'field_name_1' => [$userPermissions],
                //     'chapter' => $chapter,
                //  ]);
                //  throw $error;

                if ($userPermissions) {
                    $altPermissions = $this->altPermissions($ident);
                    return null !== $userPermissions->first(function (string $ident) use($altPermissions) {
                        return \in_array($ident, $altPermissions, true);
                    });
                }
                
                return false;
                                    

            });
        });
    }

    public function altPermissions(string $permission)
    {
        $altPermissions = ['*', $permission];
        $permParts = explode('.', $permission);

        if ($permParts && count($permParts) > 1) {
            $currentPermission = '';
            for ($i = 0; $i < (count($permParts) - 1); $i++) {
                $currentPermission .= $permParts[$i] . '.';
                $altPermissions[] = $currentPermission . '*';
            }
        }

        return $altPermissions;
    }
}
