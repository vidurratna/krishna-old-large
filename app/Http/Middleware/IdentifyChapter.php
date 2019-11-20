<?php

namespace App\Http\Middleware;

use App\Services\ChapterManager;
use Closure;

class IdentifyChapter
{

    protected $chapterManager;

    public function __construct(ChapterManager $chapterManager)
    {
        $this->chapterManager = $chapterManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        $pos = strpos($host, env('MAIN_DOMAIN'));
        
        if ($this->chapterManager->loadChapter($pos !== false ? substr($host, 0, $pos - 1) : $host, $pos !== false)) {
            return $next($request);
        }
        
        throw new NotFoundHttpException;
    }
}
