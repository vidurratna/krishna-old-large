<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'posts' => 'App\Post',
            'tags' => 'App\Tag',
            'events' => 'App\Event',
            'contentModules'=>'App\ContentModule',
            'chapters' => 'App\Chapter',
            'addresses' => 'App\Address'
        ]);
    }
}
