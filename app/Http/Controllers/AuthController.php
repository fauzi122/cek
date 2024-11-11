<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Support\Carbon;


class AuthController extends Controller
{

    public function authenticateWithToken(Request $request)
    {
        $token = $request->input('token');
        
        if ($token) {
            $encryption_key = env('APP_ENCRYPTION_KEY');
            $decoded = base64_decode($token);
            $iv = substr($decoded, 0, 16);
            $encryptedData = substr($decoded, 16);
            $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $encryption_key, 0, $iv);
            $data = json_decode($decryptedData, true);
        } else {
            $data = [
                'username' => 'guest',
                'exp' => Carbon::now()->addHours(2)->timestamp
            ];
        }
    
        $user =User::where('username', $data['username'])->first();

        if (!$user) {
            // Tentukan URL aplikasi asal berdasarkan environment
            if (app()->environment('production')) {
                $originAppUrl = 'https://elearning.nusamandiri.ac.id/dashboard'; // URL aplikasi asal di production
                $secure = true; // Aktifkan Secure cookie di production
            } else {
                $originAppUrl = 'http://127.0.0.1:8000/dashboard'; // URL aplikasi asal di local
                $secure = false; // Nonaktifkan Secure cookie di local development
            }
        
            // Set cookie error_message dengan HttpOnly dan Secure yang disesuaikan
            return redirect($originAppUrl)->withCookie(cookie(
                'error_message', 'Akses ditolak, hubungi baak', 1, null, null, true, $secure // HttpOnly diaktifkan, Secure disesuaikan
            ));
        }
        
    auth()->login($user);
       UserLogin::create([
            'user_id' => $user->id,
            'login_time' => Carbon::now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);
    
        return redirect()->route('dashboard');
    }
}
