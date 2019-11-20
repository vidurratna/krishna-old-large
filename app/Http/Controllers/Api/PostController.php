<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Post\CreateRequest;
use App\Post;
use App\Services\ChapterManager;

class PostController extends Controller
{

    function __construct()
    {
        return $this->middleware('auth:api')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {

        $this->authorize('chapter.post.store');

        $post = Post::create($request->all());

        return response([
            'message'=>'Post was created!',
            'data'=>$post
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($post)
    {
        $post = Post::find($post);

        if($post)
        {
            return response(['data'=>$post]);
        } 
        else 
        {
            return response(['message'=>'Did not find a post matching that ID'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post)
    {
        $this->authorize('chapter.post.update');

        $post = Post::find($post);

        if($post)
        {
            // do stuff;    
        } 
        else 
        {
            return response(['message'=>'Did not find a post matching that ID'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($post)
    {

        $this->authorize('chapter.post.destroy');

        $post = Post::find($post);

        if($post)
        {
            $currentChapter = app(ChapterManager::class)->getChapter();
            if($currentChapter->id === $post->chapter_id){
                $post->delete();
                return response(['message'=>'Post has been deleted!']);
            } else {
                return response(['message'=>'Post does not belong to this chapter so it can not be deleted!'],401);
            }
            
        } 
        else 
        {
            return response(['message'=>'Did not find a post matching that ID'],404);
        }
    }
}
