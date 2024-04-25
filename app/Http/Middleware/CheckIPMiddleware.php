<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckIPMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $ipFull = ambilIP();
        $ipParts = explode('.', $ipFull);
        $ipThreeOctets = implode('.', array_slice($ipParts, 0, 3));
        $cekip = DB::table('ip_absen')
            ->where('ip', $ipThreeOctets)
            ->exists();

        if ($cekip) {
            return $next($request);
        } else {
            return response('Forbidden - Your IP is not allowed. (' . $ipThreeOctets . ')', 403);
        }
    }
}
