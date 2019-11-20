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

}
