<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $available = config('app.available_locales');
        if ($request->has('lang') && in_array($lang = $request->get('lang'), $available)) {
            App::setLocale($lang);
        } else {
            $default = config('app.default_locale');
            App::setLocale($default);
        }
        return $next($request);
    }
}
