<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hasAdmin = false;
        if(!empty(Auth::check())){
            $user = Auth::user();
            $hasAdmin = $user->hasRole('admin');
        }
        if($hasAdmin){
            return $next($request);
        }else{
            Auth::logout();
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
