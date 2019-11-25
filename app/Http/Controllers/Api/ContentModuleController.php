<?php

namespace App\Http\Controllers\Api;

use App\Chapter;
use App\ContentModule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Module\CreateRequest;
use App\Post;
use App\Services\ChapterManager;
use Illuminate\Http\Request;

class ContentModuleController extends Controller
{

    function __construct()
    {
        return $this->middleware('auth:api')->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->authorize('admin.content.index');

        $content = ContentModule::orderBy('created_at','desc')->paginate(15);

        return response($content);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $this->authorize('chapter.content.store');

        $module = ContentModule::create($request->all());

        //$post= Post::find($request->content_module_id);
        //$post->content()->save($module);

        return response([
            'message'=>'Module was created!',
            'data'=>$module
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ContentModule  $contentModule
     * @return \Illuminate\Http\Response
     */
    public function show($contentModule)
    {
        $contentModule = ContentModule::find($contentModule);

        if($contentModule)
        {
            return response(['data'=>$contentModule]); 
        } 
        else 
        {
            return response(['message'=>'Did not find a Content Module matching that ID'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContentModule  $contentModule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contentModule)
    {
        $this->authorize('chapter.content.update');

        $contentModule = ContentModule::find($contentModule);

        if($contentModule)
        {
            $currentChapter = app(ChapterManager::class)->getChapter();
            if($currentChapter->id === $contentModule->chapter_id){
                $contentModule->update($request->all());
                return response([
                    'message'=>'Content Module was updated!',
                    'data'=>$contentModule
                ],200);
            } else {
                return response(['message'=>'Content Module does not belong to this chapter so it can not be updated!'],401);
            } 
        } 
        else 
        {
            return response(['message'=>'Did not find a Content Module matching that ID'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContentModule  $contentModule
     * @return \Illuminate\Http\Response
     */
    public function destroy($contentModule)
    {
        $this->authorize('chapter.content.destroy');

        $contentModule = ContentModule::find($contentModule);

        if($contentModule)
        {
            $currentChapter = app(ChapterManager::class)->getChapter();
            if($currentChapter->id === $contentModule->chapter_id){
                $contentModule->delete();
                return response([
                    'message'=>'Content Module was deleted!',
                ],200);
            } else {
                return response(['message'=>'Content Module does not belong to this chapter so it can not be updated!'],401);
            } 
        } 
        else 
        {
            return response(['message'=>'Did not find a Content Module matching that ID'],404);
        }
    }
}
