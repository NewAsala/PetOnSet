<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locales = config('localization.locales');
        $routeLocale = $request->route('locale');
        $locale = is_string($routeLocale) && array_key_exists($routeLocale, $locales)
            ? $routeLocale
            : $request->session()->get('locale', config('app.locale'));

        if (! array_key_exists($locale, $locales)) {
            $locale = config('app.fallback_locale');
        }

        if (! array_key_exists($locale, $locales)) {
            $locale = array_key_first($locales);
        }

        $request->session()->put('locale', $locale);
        app()->setLocale($locale);
        URL::defaults(['locale' => $locale]);
        $request->route()->forgetParameter('locale');

        return $next($request);
    }
}
