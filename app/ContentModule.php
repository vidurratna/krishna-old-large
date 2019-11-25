<?php

namespace App;

use App\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class ContentModule extends Model
{
    use UsesUuid;

    protected $guarded = [];

    protected $casts = [
        'level' => 'priority',
        'content' => 'json'
    ];

    public function content_moduleable()
    {
        return $this->morphTo();
    }
}
