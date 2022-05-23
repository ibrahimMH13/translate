<?php

namespace Ibrhaim13\Translate\Http\Middleware\Api;

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
        $local = $request->header("X-Localization");
        if(in_array($local,config("app.locales"))){
            app()->setLocale($local);
        }
        return $next($request);
    }
}
