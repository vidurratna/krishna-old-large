<?php

namespace App\Providers;

use App\Chapter;
use App\Services\ChapterManager;
use Illuminate\Support\ServiceProvider;

class ChapterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $manager = new ChapterManager;

        $this->app->instance(ChapterManager::class, $manager);
        $this->app->bind(Chapter::class, function () use ($manager) {
            return $manager->getChapter();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
