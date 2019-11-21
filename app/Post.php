<?php

namespace App;

use App\Concerns\OwnedByChapter;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Post extends Model
{
    use OwnedByChapter;

    protected $guarded = [];

    protected $casts = [
        'isGlobal' => 'bool',
    ];

    public function owner()
    {
        return $this->chapter;
    }

    public function my_chapter()
    {
        $this->belongsTo('App\Chapter');
    }

    public function content()
    {
        return $this->morphMany('App\ContentModule', 'content_module');
    }

}
