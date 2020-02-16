<?php

namespace App;

use App\Concerns\OwnedByChapter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;


class Tag extends Model
{

    use OwnedByChapter;

    protected $guarded = [];

    protected $casts = [
        'isGlobal' => 'bool',
    ];

    public function posts()
    {
        return $this->morphedByMany('App\Post', 'taggable');
    }

    public function events()
    {
        return $this->morphedByMany('App\Event', 'taggable');
    }

    public function my_chapter()
    {
        $this->belongsTo('App\Chapter');
    }

    public static function allTags($all)
    {
        if($all) 
        {
            return $tags = DB::table('tags')
                    ->paginate(15);
        } 
        else 
        {
            return $tags = app(Pipeline::class)
                    ->send(Tag::query())
                    ->through([
                        \App\QueryFilters\Sort::class,
                    ])
                    ->thenReturn()
                    ->paginate(15);
        }
    }
    
}
