<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckForMaliciousUploads
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $maliciousExtensions = [
            'php', 'php3', 'php4', 'php5', 'phtml', 'py', 'go', 'alfa', 
            'pl', 'cgi', 'sh', 'bash', 'ps1', 'rb', 'asp', 'aspx', 'jsp', 
            'jspx', 'do', 'js', 'exe', 'bat', 'cmd', 'com', 'pyc', 'pyo', 
            'lua', 'class', 'jar', 'kt', 'kts'
        ];
    
        $files = Storage::disk('local')->allFiles('public');
    
        foreach ($files as $file) {
            Log::info("Checking file:", ['file' => $file]); // Tambahkan logging di sini
            if (in_array(pathinfo($file, PATHINFO_EXTENSION), $maliciousExtensions)) {
                Storage::disk('local')->delete($file);
                Log::info("Deleted malicious file:", ['file' => $file]); // Tambahkan logging di sini
            }
        }
    
        return $next($request);
    }
    
}
