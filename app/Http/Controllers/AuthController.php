<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use App\Models\{User};


class AuthController extends Controller
{

    public function authenticateWithToken(Request $request)
    {
        $token = $request->query('token');
        if (!$token) {
            return response()->json(['error' => 'No token provided'], 400);
        }

        JWTAuth::setToken($token);

        try {
            $username = JWTAuth::parseToken()->getPayload()->get('sub');
            $userPayload = User::where('username', $username)->first();
            if (!$userPayload) {
                return redirect('/')->with('error', 'Data anda tidak ada pada sistem ujian');
            }
            Auth::login($userPayload);
            // $check = Auth::check(); // Harusnya mengembalikan true jika pengguna terautentikasi
            // dd(Auth::user()->username);
            return redirect('/dashboard');
        } catch (TokenExpiredException $e) {
            // Tangani kasus ketika token sudah kedaluwarsa
            return back()->with('error', 'Token has expired');
        } catch (TokenInvalidException $e) {
            // Tangani kasus ketika token tidak valid
            return back()->with('error', 'Token is invalid');
        } catch (JWTException $e) {
            // Tangani kesalahan lain yang terkait dengan JWT
            return back()->with('error', 'Error fetching token');
        }
    }
}
