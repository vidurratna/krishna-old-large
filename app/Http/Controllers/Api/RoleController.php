<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
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
        return response(['data'=>Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $role = Role::create($request->all());

        return response([
            'message'=>'Role was created!',
            'data'=>$role
        ],201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($role)
    {
        $role = Role::find($role);

        if($role)
        {
            return response(['data'=>$role]);
        } 
        else 
        {
            return response(['message'=>'Did not find a role matching that ID'],404);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update($role)
    {

        $role = Role::find($role);

        if($role)
        {
            $role['active']=1;

            $role->save();

            $this->forgetCache();

            return response([
                'message'=> $role->name.' was set to active!',
                'data'=>$role
            ]);
        } 
        else 
        {
            return response(['message'=>'Did not find a role matching that ID'],404);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($role)
    {
        $role = Role::find($role);

        if($role)
        {
            $role['active']=0;

            $role->save();

            $this->forgetCache();

            return response([
                'message'=> $role->name.' was set to inactive!',
                'data'=>$role
            ]);
        } 
        else 
        {
            return response(['message'=>'Did not find a role matching that ID'],404);
        }
    }

    private function forgetCache()
    {
        Cache::forget('permissions');

        User::all()->each(function(User $user) {

            Cache::forget('user.'.$user->id . '.permissions');
            
        });
    }

    


    public function asignRole(User $user, Role $role)
    {

        DB::table('user_roles')->insert([
            ['role_id' => $role->id, 'user_id' => $user->id]
        ]);

        $this->forgetCache();
        
        return response(['message' => $user->first_name." was added to ". $role->name]);
    }
}
