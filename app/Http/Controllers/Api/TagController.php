<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\AsignRequest;
use App\Http\Requests\Tag\CreateRequest;
use App\Http\Requests\Tag\UpdateRequest;
use App\Services\ChapterManager;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
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
    public function index(Request $request)
    {
        if($request->all === 'true'){

            //$this->authorize('admin.tags.index');

            $tags = DB::table('tags')
                    ->paginate(15);

            return response($tags);

        } else {

            $tags = Tag::orderBy('created_at','desc')->paginate(15);

            return response(['data'=>$tags]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {

        //$this->authorize('chapter.tags.store');

        $tag=$request->all();

        $tag['last_modified']=$request->created_by;

        $tag = Tag::create($tag);

        return response([
            'message'=>'Tag was created!',
            'data'=>$tag
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show($tag)
    {
        $tag = Tag::find($tag);

        if($tag)
        {
            return response(['data'=> $tag]);
        } 
        else 
        {
            return response(['message'=>'Did not find a Tag matching that ID'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $tag)
    {

        //$this->authorize('chapter.tags.update');

        $tag = Tag::find($tag);

        if($tag)
        {
            $currentChapter = app(ChapterManager::class)->getChapter();
            if($currentChapter->id === $tag->chapter_id){
                $tag->update($request->all());
                return response([
                    'message'=>'Tag was updated!',
                    'data'=>$tag
                ],200);
            } else {
                return response(['message'=>'Tag does not belong to this chapter so it can not be updated!'],401);
            } 
        } 
        else 
        {
            return response(['message'=>'Did not find a tag matching that ID'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($tag)
    {
        
        //$this->authorize('chapter.tags.destroy');

        $tag = Tag::find($tag);

        if($tag)
        {
            $currentChapter = app(ChapterManager::class)->getChapter();
            if($currentChapter->id === $tag->chapter_id){
                $tag->delete();
                return response(['message'=> 'Tag has been deleted!']);
            } else {
                return response(['message'=>'Tag does not belong to this chapter so it can not be updated!'],401);
            } 
        } 
        else 
        {
            return response(['message'=>'Did not find a tag matching that ID'],404);
        }
    }


    public function asign(AsignRequest $request, $tag)
    {

        //$this->authorize('chapter.tags.asign');

        $tag = Tag::find($tag);

        if($tag)
        {
            DB::table('taggables')->insert([
                [
                    'tag_id'=>$tag->id,
                    'taggable_id'=>$request->id,
                    'taggable_type'=>$request->type
                ]
            ]);

            return response(['message'=> $request->type. " with id of ". $request->id." has been asigned to tag: ".$tag->name]);
        } 
        else 
        {
            return response(['message'=>'Did not find a Tag matching that ID'],404);
        }
    }
}
