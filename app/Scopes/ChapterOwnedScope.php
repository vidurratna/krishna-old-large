<?php

namespace App\Scopes;

use App\Services\ChapterManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ChapterOwnedScope implements Scope {
    public function apply(Builder $builder, Model $model) 
    {
        $mananger = app(ChapterManager::class);

        $builder->where('chapter_id', '=', $mananger->getChapter()->id)->orWhere('isGlobal', '=', 1);
        
    }

    public function extend(Builder $builder) {
        $this->addWithoutTenancy($builder);
    }

    protected function addWithoutTenancy(Builder $builder) {
        $builder->macro('withoutTenancy', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}