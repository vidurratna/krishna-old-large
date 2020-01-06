<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $password = $request['password'];
        $request['password'] = bcrypt($request['password']);

        User::create($request->all());

        if(Auth::attempt(['email' => $request->email, 'password' => $password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Krishna')->accessToken;
            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error'=>"Unauthorized"], 401);
        }
         
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
