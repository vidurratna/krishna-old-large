<?php

namespace App;

use App\Concerns\OwnedByChapter;
use Illuminate\Database\Eloquent\Model;

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
    
}
