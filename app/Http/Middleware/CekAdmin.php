<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CekAdmin
{

    public function handle($request, Closure $next)
    {
        $roles = Auth::user()->utype;
        if($roles=='ADM')
        {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
