<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\Address\AsignRequest;
use App\Http\Requests\Address\CreateRequest;
use App\Http\Requests\Address\IndexRequest;
use App\Http\Requests\Address\UpdateRequest;
use App\Services\ChapterManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
     // function __construct()
    // {
    //     return $this->middleware('auth:api')->except('show');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {

        $currentChapter = app(ChapterManager::class)->getChapter();

        if($request->all == '1' || $request->all == 'true'){

            //$this->authorize('chapter.addresses.all', $currentChapter);
            
            return Address::all();
        }

        //$this->authorize('chapter.addresses.public', $currentChapter);

        return Address::where('isGlobal',true)->paginate(15);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $currentChapter = app(ChapterManager::class)->getChapter();

        //$this->authorize('chapter.address.store', $currentChapter);

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
    public function show($address)
    {
        $address = Address::find($address);

        if($address)
        {
            if($address->isGlobal == false){
                $currentChapter = app(ChapterManager::class)->getChapter();

                $this->authorize('chapter.address.show', $currentChapter);

                return response(['data'=>$address]); 
            }
            return response(['data'=>$address]); 
        } 
        else 
        {
            return response(['message'=>'Did not find a address matching that ID'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $address)
    {
        $currentChapter = app(ChapterManager::class)->getChapter();

        //$this->authorize('chapter.address.update', $currentChapter);

        $address = Address::find($address);

        if($address)
        {
            $address->update($request->all());
            return response([
                'message'=>'Address was updated!',
                'data'=>$address
            ],200);
        } 
        else 
        {
            return response(['message'=>'Did not find a Address matching that ID'],404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy($address)
    {
        $currentChapter = app(ChapterManager::class)->getChapter();

        //$this->authorize('chapter.address.destroy', $currentChapter);
   
        $address = Address::find($address);

        if($address)
        {
            $address->delete();
            return response(['message'=>'Address has been deleted!']);
        } 
        else 
        {
            return response(['message'=>'Did not find a Address matching that ID'],404);
        }
    }

    public function assign(AsignRequest $request, $address)
    {

        $currentChapter = app(ChapterManager::class)->getChapter();

        //$this->authorize('chapter.address.asign', $currentChapter);

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

            return response(['message'=> $request->type. " with id of ". $request->id." has been assigned to address: ".$address->name]);
        } 
        else 
        {
            return response(['message'=>'Did not find a Tag matching that ID'],404);
        }
    }
}
