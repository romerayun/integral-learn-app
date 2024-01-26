<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogsActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {

            activity()
                ->causedBy(auth()->user())
                ->performedOn(auth()->user())
                ->event('default')
                ->log("Пользователь посетил - {$request->fullUrl()}");
        }
        return $next($request);
    }
}
