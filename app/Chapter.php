<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $guarded = [];

    public function route($name, $parameters = []) {
        return 'http://' . $this->subdomain . app('url')->route($name, $parameters, false);
    }
}
