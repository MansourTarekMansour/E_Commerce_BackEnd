<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocaleLang
{
    public function handle($request, Closure $next)
    {
        $locale = $request->header('lang');
        if ($locale) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
