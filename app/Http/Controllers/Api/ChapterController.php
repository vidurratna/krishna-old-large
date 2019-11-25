<?php

namespace App\Http\Controllers\Api;

use App\Chapter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chapter\CreateRequest;
use App\Http\Requests\Chapter\UpdateRequest;
use App\Services\ChapterManager;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
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
        $chpaters = Chapter::orderBy('created_at','desc')->paginate(15);

        return response($chpaters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $this->authorize('krishna.chapter.store');

        $chapter = Chapter::create($request->all());

        return response([
            'message'=>'Chapter was created!',
            'data'=>$chapter
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function show($chapter)
    {
        $chapter = Chapter::find($chapter);

        if($chapter)
        {
            // use App\Services\ChapterManager;
            // $currentChapter = app(ChapterManager::class);
            // $currentChapter->loadLocalChapter($chapter);
            // $chapter->posts;
            // $currentChapter->unloadLocalChapter();
            //
            // TO send chapter spefic data.

            $chapter['address']=$chapter->address()->get();

            return response(['data'=>$chapter]);
        } 
        else 
        {
            return response(['message'=>'Did not find a chapter matching that ID'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $chapter)
    {
        $this->authorize('krishna.chapter.update');

        $chapter = Chapter::find($chapter);

        if($chapter)
        {
            $chapter->update($request->all());
            return response([
                'message'=>'Chapter was updated!',
                'data'=>$chapter
            ],200);
        } 
        else 
        {
            return response(['message'=>'Did not find a Chapter matching that ID'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function destroy($chapter)
    {

        $this->authorize('krishna.chapter.destroy');

        $chapter = Chapter::find($chapter);

        if($chapter)
        {
            $chapter->delete();
            return response([
                'message'=>'Chapter was deleted!'
            ],200);
        } 
        else 
        {
            return response(['message'=>'Did not find a Chapter matching that ID'],404);
        }
    }

    public function join($user, $chapter)
    {

        //$this->authorize('krishna.user.join');

        $user = User::find($user);

        if($user)
        {
            $chapter = Chapter::find($chapter);

            if($chapter)
            {
                if($user->chapters()->where('id',$chapter->id)->exists()){
                    return response(['message'=>$user->first_name.' is already a part of '. $chapter->name],409);
                } else {
                    DB::table('chapter_user')->insert([
                        ['chapter_id'=>$chapter->id, 'user_id'=>$user->id]
                    ]);
    
                    return response(['message'=> $user->first_name. ' was added to ' . $chapter->name]);
                }
            } 
            else 
            {
                return response(['message'=>'Did not find a Chapter matching that ID'],404);
            }
        } 
        else 
        {
            return response(['message'=>'Did not find a user matching that ID'],404);
        }
    }

    public function leave($user, $chapter)
    {

        $this->authorize('krishna.user.leave');

        $user = User::find($user);

        if($user)
        {
            $chapter = Chapter::find($chapter);

            if($chapter)
            {
                if(!$user->chapters()->where('id',$chapter->id)->exists()){
                    return response(['message'=>$user->first_name.' is already NOT a part of '. $chapter->name],409);
                } else {
                    $user->chapters()->wherePovit('chapter_id','=',$chapter->id)->detach();
    
                    return response(['message'=> $user->first_name. ' was removed from ' . $chapter->name]);
                }
            } 
            else 
            {
                return response(['message'=>'Did not find a Chapter matching that ID'],404);
            }
        } 
        else 
        {
            return response(['message'=>'Did not find a user matching that ID'],404);
        }
    }

    public function list($user)
    {
        $this->authorize('krishna.user.chapters');

        $user = User::find($user);

        if($user)
        {
            return response(['data'=>$user->chapters()->get()]);
        } 
        else 
        {
            return response(['message'=>'Did not find a User matching that ID'],404);
        }
    }

    public function users()
    {
        $this->authorize('chapter.user.list');

        $currentChapter = app(ChapterManager::class)->getChapter();

        return $currentChapter->users()->orderBy('last_name')->paginate(15);

    }
}
