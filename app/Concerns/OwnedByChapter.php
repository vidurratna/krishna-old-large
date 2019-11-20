<?php

namespace App\Concerns;

use App\Scopes\ChapterOwnedScope;
use App\Services\ChapterManager;

trait OwnedByChapter {
    public static function bootOwnedByChapter()
    {
        static::addGlobalScope(new ChapterOwnedScope);

        static::creating(function ($model) {
            if(! $model->tenant_id && ! $model->relationLoaded('chapter')) {
                $model->setRelation('chapter', app(ChapterManager::class)->getChapter());
            }

            return $model;
        });
    }

    public function chapter() {
        $this->belongsTo(Tenant::class, 'chapter_id');
    }
}
