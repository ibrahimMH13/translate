<?php

namespace Ibrhaim13\Translate\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->isIgnoreRoutePath($request->getPathInfo())) return $next($request);
        $locale = $request->segment(1);
        if (!array_key_exists($locale, config('translate13.locales'))) {
            $segments = $request->segments();
            array_unshift($segments, config('app.fallback_locale'));
            return redirect()->to($this->buildRoutePath($segments, $request));
        }        app()->setLocale($locale);
        return $next($request);
    }

    private function isIgnoreRoutePath(string $getPathInfo):bool
    {
        foreach ($this->getIgnorableRoutesPatterns() as $routesPattern){
            if (preg_match($routesPattern, $getPathInfo)) return true;
        }
        return false;
    }

    private function getIgnorableRoutesPatterns():array
    {
        return [
           // '/oauth/i'
        ];
    }

    /**
     * @param array $segments
     * @param Request $request
     * @return string
     */
    public function buildRoutePath(array $segments, Request $request): string
    {
        return implode('/', $segments) . ($request->server('QUERY_STRING') ? '?' . $request->server('QUERY_STRING') : '');
    }

}
