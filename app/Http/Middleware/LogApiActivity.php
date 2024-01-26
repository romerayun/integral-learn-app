<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogApiActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

//        activity()
//                ->causedBy(auth()->user())
////                ->performedOn()
//            ->event('default')
//                ->log("Пользователь посетил - {$request->method()}");

//        if ($request->is('api/*') && Auth::check()) {
//            $user = Auth::user();
//            $activityDescription = $this->getActivityDescription($request);
//
//            activity()
//                ->causedBy(auth()->user())
//                ->performedOn(auth()->user())
//                ->log("Пользователь посетил - {$request->fullUrl()}");
//        }

        return $response;
    }

    private function getActivityDescription($request)
    {
        // You can customize this based on your needs
        return $request->method() . ' ' . $request->path();
    }
}
