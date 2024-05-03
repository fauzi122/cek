<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {

        $captcha = $this->generateCaptcha(); // Generate CAPTCHA
        session(['captcha_answer' => $captcha['answer']]); // Store the expected answer in session
        return view('auth.login', compact('captcha'));
    }
//     public function create(): Responsable
// {
//     // Cek jika pengguna sudah terautentikasi
//     // if (!Auth::check()) {
//         // Jika tidak, arahkan ke halaman login di Web 1
//         return redirect('https://elearning.bsi.ac.id');
//     // }

//     // $captcha = $this->generateCaptcha(); // Generate CAPTCHA
//     // session(['captcha_answer' => $captcha['answer']]); // Store the expected answer in session

//     // return view('auth.login', compact('captcha'));
// }

    private function generateCaptcha()
    {
        $num1 = random_int(1, 10);
        $num2 = random_int(1, 10);
        $answer = $num1 + $num2;

        return ['question' => "Berapa hasil dari $num1 + $num2?", 'answer' => $answer];
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     Auth::guard('web')->logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect('https://elearning.bsi.ac.id/dashboard');
    // }
    public function destroy(Request $request): RedirectResponse
{
    // Mendapatkan user yang sedang login
    $user = Auth::guard('web')->user();

    // Logout user
    Auth::guard('web')->logout();

    // Jika user ditemukan, update atau hapus session_id di database
    if ($user) {
        $user->session_id = null; // Atau bisa juga $user->session_id = '';
        $user->save();
    }

    // Invalidate session
    $request->session()->invalidate();

    // Regenerate token
    $request->session()->regenerateToken();

    // Redirect user
    return redirect('https://elearning.bsi.ac.id/dashboard');
}

}
