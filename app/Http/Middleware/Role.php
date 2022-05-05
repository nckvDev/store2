<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, String $role)
    {
        if (!Auth::check()) // This is not necessary, it should be part of your 'auth' middleware
            return redirect('/home');

        $user = Auth::user();
        if($user->role == $role)
            return $next($request);

        return redirect('/home');
    }
}
