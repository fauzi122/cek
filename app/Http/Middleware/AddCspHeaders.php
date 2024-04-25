<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddCspHeaders
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
        // Generate nonce
        $nonce = base64_encode(random_bytes(16));

        // Store nonce in the session for later use in views
        $request->session()->put('csp-nonce', $nonce);

        $response = $next($request);

        // $response->headers->set(
        //     'Content-Security-Policy',
        //     "default-src 'self';" .
        //         "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://code.jquery.com https://cdnjs.cloudflare.com http://localhost:5173;" . // Tambahkan localhost:5173
        //         "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://code.ionicframework.com https://cdnjs.cloudflare.com http://localhost:5173;" . // Tambahkan localhost:5173
        //         "img-src 'self' https://ytimg.com http://localhost:5173;" . // Tambahkan localhost:5173
        //         "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net;" .
        //         "frame-src 'self' https://www.youtube.com https://youtube.com;" . // Added for YouTube iframes
        //         "connect-src 'self' ws://localhost:5173;"
        // );

        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self';" .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://code.jquery.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://ajax.googleapis.com http://localhost:5173;" . // Menambahkan ajax.googleapis.com
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net http://localhost:5173;" .
            "img-src 'self' https://ytimg.com http://localhost:5173;" .
            "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net;" .
            "frame-src 'self' https://www.youtube.com https://youtube.com;" .
            "connect-src 'self' ws://localhost:5173;"
        );
        
        

        return $response;
    }
}
