<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Role;
use App\Services\ChapterManager;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    function __construct()
    {
        return $this->middleware('auth:api')->except('register','login');
    }

    public function register(RegisterRequest $request)
    {

        $password = $request['password'];
        $request['password'] = bcrypt($request['password']);

        $user = User::create($request->all());
        $addressRequest = [
            'name' => $user->id,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'region' => $request->region,
            'country' => $request->country,
            'created_by'=> $user->id,
            'last_modified'=> $user->id,
        ];
        $address = Address::create($addressRequest);

        DB::table('addressables')->insert([
            [
                'address_id'=>$address->id,
                'addressable_id'=>$user->id,
                'addressable_type'=>'users'
            ]
        ]);

        $role = Role::get()->where("level",0)->first();
        $currentChapter = app(ChapterManager::class)->getChapter();

        DB::table('user_role_chapter')->insert([
            [
                'role_id'=>$role->id,
                'user_id'=>$user->id,
                'chapter_id'=>$currentChapter->id,
            ]
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $password])) {
            $user = Auth::user();
            $success = $user->createToken('Krishna')->accessToken;
            return response()->json(
                [
                    'token' => $success,
                    'user' => $user,
                ], 200
            );
        } else {
            return response()->json(['error'=>"Unauthorized"], 401);
        }
         
    }
    
    public function show()
    {
        $user = Auth::user();
        $user->address;
        $user->chapters;
        return response()->json(
            [
                'user' => $user
            ], 200
        );
    }

    public function login(LoginRequest $request)
    {
        // $http = new Client;

        // $response = $http->post(url('oauth/token'), [
        //     'form_params' => [
        //         'grant_type' => 'password',
        //         'client_id' => '2',
        //         'client_secret' => 'dNr0hzx7j921No7m42tyJy7pH86vlViCTnFFpVYW',
        //         'username' => $request->email,
        //         'password' => $request->password,
        //         'scope' => '',
        //     ],
        // ]);
    
        // return response(['data' => json_decode((string) $response->getBody(), true)]);
         

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success = $user->createToken('Krishna')->accessToken;
            return response()->json(
                [
                    'token' => $success,
                    'user' => $user,
                ], 200
            );
        } else {
            return response()->json(['error'=>"Unauthorized"], 401);
        }
    }
}
