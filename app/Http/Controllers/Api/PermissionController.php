<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\CreateRequest;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{

    // function __construct()
    // {
    //     return $this->middleware('auth:api');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(['data'=>Permission::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $permission = Permission::create($request->all());

        return response([
            'message'=>'Permission was created',
            'data'=>$permission
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($permission)
    {
        $permission = Permission::find($permission);

        if($permission)
        {
            return response(['data'=>$permission]);
        } 
        else 
        {
            return response(['message'=>'Did not find a permission matching that ID'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update($permission)
    {
        $permission = Permission::find($permission);

        if($permission)
        {
            $permission['active']=1;

            $permission->save();

            $this->forgetCache();

            return response([
                'message'=> $permission->name.' was set to active!',
                'data'=>$permission
            ]);
        } 
        else 
        {
            return response(['message'=>'Did not find a permission matching that ID'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($permission)
    {
        $permission = Permission::find($permission);

        if($permission)
        {
            $permission['active']=0;

            $permission->save();

            $this->forgetCache();

            return response([
                'message'=> $permission->name.' was set to inactive!',
                'data'=>$permission
            ]);
        } 
        else 
        {
            return response(['message'=>'Did not find a permission matching that ID'],404);
        }
    }

    private function forgetCache()
    {
        Cache::forget('permissions');

        User::all()->each(function(User $user) {

            Cache::forget('user.'.$user->id . '.permissions');
        });
    }

    public function asignRole(Permission $permission, Role $role)
    {
        DB::table('role_permissions')->insert([
            ['role_id' => $role->id, 'permission_id' => $permission->id]
        ]);

        $this->forgetCache();
        
        return response(['message' => $permission->ident." was added to ". $role->name]);
    }
}
