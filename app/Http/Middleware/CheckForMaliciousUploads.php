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
        'php',     // PHP script
        'php3',    // PHP script version 3
        'php4',    // PHP script version 4
        'php5',    // PHP script version 5
        'phtml',   // PHP HTML embedded script
        'py',      // Python script
        'go',      // Go script
        'alfa',    // Custom/unknown script
        'pl',      // Perl script
        'cgi',     // Common Gateway Interface script
        'sh',      // Shell script
        'bash',    // Bash script
        'ps1',     // PowerShell script
        'rb',      // Ruby script
        'asp',     // ASP.NET script
        'aspx',    // ASP.NET webform
        'jsp',     // Java Server Pages
        'jspx',    // Java Server Pages XML
        'do',      // Java Web Action (Struts)
        'js',      // JavaScript (Node.js)
        'exe',     // Windows executable
        'bat',     // Batch file (Windows)
        'cmd',     // Command file (Windows)
        'com',     // Command file (DOS)
        'pyc',     // Compiled Python script
        'pyo',     // Optimized Python bytecode
        'lua',     // Lua script
        'class',   // Java compiled class
        'jar',     // Java archive
        'kt',      // Kotlin script
        'kts'      // Kotlin script
    ];
    
    $files = Storage::disk('public')->allFiles();

    foreach ($files as $file) {
        if (in_array(pathinfo($file, PATHINFO_EXTENSION), $maliciousExtensions)) {
            Storage::disk('public')->delete($file);
            
            // Menulis log penghapusan file
            Log::info("File dengan ekstensi berbahaya dihapus:", ['file' => $file]);
        }
    }

    return $next($request);
}
}
