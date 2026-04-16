<?php

namespace App\Http\Middleware;

use App\Support\LocalizedRouteSlugs;
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
        URL::defaults(array_merge(
            ['locale' => $locale],
            LocalizedRouteSlugs::defaultsForLocale($locale)
        ));

        $route = $request->route();
        $routeName = $route?->getName();
        $routeParameters = $route
            ? array_intersect_key($route->parameters(), array_flip($route->parameterNames()))
            : [];

        if (
            $routeName &&
            in_array($request->method(), ['GET', 'HEAD'], true) &&
            LocalizedRouteSlugs::hasMismatch($routeName, $routeParameters, $locale)
        ) {
            $parameters = LocalizedRouteSlugs::applyLocalizedParameters($routeName, $routeParameters, $locale);
            $targetUrl = route($routeName, $parameters, false);
            $queryString = $request->getQueryString();

            if ($queryString) {
                $targetUrl .= '?'.$queryString;
            }

            return redirect($targetUrl, 302);
        }

        return $next($request);
    }
}
