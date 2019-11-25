<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $guarded = [];

    public function address()
    {
        return $this->morphToMany('App\Address', 'addressable');
    }
}
