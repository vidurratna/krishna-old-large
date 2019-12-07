<?php

namespace App\Http\Controllers\Api;

use App\ContentModule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Post;
use App\Services\ChapterManager;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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

        $posts = Post::orderBy('published','desc')->paginate(15);

        return response($posts);
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

        $this->authorize('chapter.post.store', $currentChapter);

        $post = $request->all();

        $post['last_modified']=$request->created_by;

        $post = Post::create($post);

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
            $post['content']=$post->content()->orderBy('priority','asc')->get();
            $post['chapter']=$post->owner()->display();
            $post['tags']=$post->tags()->get();
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
    public function update(UpdateRequest $request, $post)
    {
        $currentChapter = app(ChapterManager::class)->getChapter();

        $this->authorize('chapter.post.update', $currentChapter);

        $post = Post::find($post);

        if($post)
        {
            if($currentChapter->id === $post->chapter_id){
                $post->update($request->all());
                return response([
                    'message'=>'Post was updated!',
                    'data'=>$post
                ],200);
            } else {
                return response(['message'=>'Post does not belong to this chapter so it can not be updated!'],401);
            } 
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
        $currentChapter = app(ChapterManager::class)->getChapter();

        $this->authorize('chapter.post.destroy', $currentChapter);

        $post = Post::find($post);

        if($post)
        {
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
