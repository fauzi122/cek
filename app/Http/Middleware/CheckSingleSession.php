<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSingleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $previous_session = Auth::User()->session_id;
        if ($previous_session !== Session::getId()) {
    
            Session::getHandler()->destroy($previous_session);
    
            $request->session()->regenerate();
            Auth::user()->session_id = Session::getId();
    
            Auth::user()->save();
        }
        return $next($request);
    }
}
