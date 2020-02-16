<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Role;
use App\Services\ChapterManager;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AuthController extends Controller
{

    function __construct()
    {
        return $this->middleware('auth:api')->except('register','login');
    }

    public function index()
    {
        return User::allUsers();
    }

    public function register(RegisterRequest $request)
    {

        $password = $request['password'];
        $request['password'] = bcrypt($request['password']);
        $request['date_of_birth'] = Carbon::createFromFormat('Y/m/d', $request->date_of_birth)->format('Y-m-d');
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
            $user->address;
            $user->chapters;
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
        $user['date_of_birth'] = Carbon::createFromFormat('Y-m-d', $user->date_of_birth)->format('d/m/Y');

        return response()->json(
            [
                'user' => $user
            ], 200
        );
    }

    public function check($user)
    {
        $user = User::find($user);
        if($user)
        {
            $user->address;
            $user->chapters;
            $user->roles;
            return $user;
        }
        else 
        {
            return response(['message'=>'Did not find a user matching that ID'],404);
        }
    }

    public function update(UpdateRequest $request){

        $user = Auth::user();
        if($request['date_of_birth']){
            $request['date_of_birth'] = Carbon::createFromFormat('Y/m/d', $request->date_of_birth)->format('Y-m-d');
        }
        if($request['isAddress']==="true"){
            $address = Address::find($request->id);
            $address->update($request->except(['isAddress', 'id']));
            $address->save();
        }
        $user->update($request->all());
        $user->save();

        $user->address;
        $user->chapters;

        return $user;
    }

    public function test() {
        $process = new Process("google-chrome-stable --headless --disable-gpu --window-size=1024,1024 --screenshot ". "http://192.168.0.158:3000/");
        $process->setTimeout(8000);
        $process->setWorkingDirectory(storage_path('/app/public/'));
        $process->run();
        if(!$process->isSuccessful()){
            throw new ProcessFailedException($process);
        }
        return "something";
    }

    public function login(LoginRequest $request)
    {
        // $http = new Client;

        // $response = $http->post(url('oauth/token'), [
        //     'form_params' => [
        //         'grant_type' => 'password',
        //         'client_id' => '2',
        //         'client_secret' => '',
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
                    'chapter' => app(ChapterManager::class)->getChapter(),
                ], 200
            );
        } else {
            return response()->json(['error'=>"Unauthorized"], 401);
        }
    }
}
