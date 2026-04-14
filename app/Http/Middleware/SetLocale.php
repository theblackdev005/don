<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $supported = config('locales.supported', ['fr']);

        $routeLocale = (string) $request->route('locale', '');
        if (in_array($routeLocale, $supported, true)) {
            $locale = $routeLocale;
            $request->session()->put('locale', $locale);
        } else {
            $locale = (string) $request->session()->get('locale', config('locales.default', 'fr'));
        }

        if (! in_array($locale, $supported, true)) {
            $locale = config('locales.default', 'fr');
        }

        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
