<?php

namespace App\Services;

use App\Chapter;

class ChapterManager {
    
    private $chapter;

    public function setChapter(?Chapter $chapter) 
    {
        $this->chapter = $chapter;

        return $this;
    }

    public function getChapter(): ?Chapter 
    {
        return $this->chapter;
    }

    public static function unique($talbe, $column = 'NULL')
    {
        return (new Rules\unique($talbe, $column))->where('chapter_id', $this->getChapter()->id);
    }

    public static function exists($talbe, $column = 'NULL')
    {
        return (new Rules\unique($talbe, $column))->where('chapter_id', $this->getChapter()->id);
    }

    public function loadChapter($identifier): bool {
        $chapter = Chapter::query()->where('subdomain', '=', $identifier)->first();

        if($chapter) {
            

            $this->setChapter($chapter);

            return true;
        }

        return false;
    }

}