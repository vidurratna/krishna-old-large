<?php

namespace App;

use App\Concerns\OwnedByChapter;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use OwnedByChapter;

    protected $guarded = [];

    protected $casts = [
        'isGlobal' => 'bool',
    ];

    public function chapter()
    {
        return $this->chapter();
    }
}
