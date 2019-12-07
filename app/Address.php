<?php

namespace App;

use App\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use UsesUuid;

    protected $guarded = [];

    protected $casts = [
        'isGlobal' => 'bool',
    ];

    public function chapters()
    {
        return $this->morphedByMany('App\Chapter', 'addressable');
    }

    public function venues()
    {
        return $this->morphedByMany('App\Venue', 'addressable');
    }
}
