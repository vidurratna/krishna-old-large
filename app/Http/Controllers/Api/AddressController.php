<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\Address\AsignRequest;
use App\Http\Requests\Address\CreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
     // function __construct()
    // {
    //     return $this->middleware('auth:api')->except('index','show');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Address::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $address=$request->all();

        $address['last_modified']=$request->created_by;

        $address = Address::create($address);

        return response([
            'message'=>'Address was created!',
            'data'=>$address
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }

    public function asign(AsignRequest $request, $address)
    {

        //$this->authorize('chapter.tags.asign');

        $address = Address::find($address);

        if($address)
        {
            DB::table('addressables')->insert([
                [
                    'address_id'=>$address->id,
                    'addressable_id'=>$request->id,
                    'addressable_type'=>$request->type
                ]
            ]);

            return response(['message'=> $request->type. " with id of ". $request->id." has been asigned to address: ".$address->name]);
        } 
        else 
        {
            return response(['message'=>'Did not find a Tag matching that ID'],404);
        }
    }
}
