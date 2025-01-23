<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockEdgeBrowser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Mengecek apakah User-Agent mengandung kata 'Edg', yang adalah identifier untuk Microsoft Edge
        if (strpos($request->header('User-Agent'), 'Edg') !== false) {
            // Jika benar, kembalikan respons yang menyatakan bahwa browser tidak didukung
            return response("Akses Ditolak - Microsoft Edge tidak didukung. Silahkan hunakan browser lain", 403);
        }
    
        return $next($request);
    }
    
}
