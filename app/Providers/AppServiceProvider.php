<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use App\Models\ThrottledIp;
use App\Models\Ip_absen;
use Illuminate\Support\Facades\Cache;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('user-agent-based', function (Request $request) {
            $ip = $request->ip();
            // Ambil tiga bagian pertama dari IP (misal: 172.16.101)
            $ipPrefix = implode('.', array_slice(explode('.', $ip), 0, 3));

            // Cek apakah IP prefix ini ada di tabel `ip_absen`
            if (Ip_absen::where('ip', $ipPrefix)->exists()) {
                // Lewati rate limiting untuk IP lokal yang cocok
                return null;
            }

            // Lanjutkan dengan rate limiting untuk IP publik atau IP lokal yang tidak terdaftar
            $identifier = $request->user()
                ? $request->user()->id . '|' . $ip . '|' . $request->header('User-Agent')
                : $ip . '|' . $request->header('User-Agent');

            // Tentukan batas rate limiter
            $limit = Limit::perMinute(1000)->by($identifier);

            // Tambahkan percobaan untuk menghitung rate limit
            RateLimiter::hit($identifier);

            // Cek apakah sudah melebihi batas percobaan
            if (RateLimiter::tooManyAttempts($identifier, 1000)) {
                $cacheKey = 'throttled_ip_' . $ip;

                // Cek apakah IP sudah ada dalam cache
                if (!Cache::has($cacheKey)) {
                    // Simpan IP ke database jika belum ada dalam cache
                    ThrottledIp::firstOrCreate(
                        ['ip_address' => $ip],
                        [
                            'user_id' => $request->user() ? $request->user()->id : null,
                            'user_agent' => $request->header('User-Agent'),
                            'throttled_at' => now(),
                        ]
                    );

                    // Simpan ke cache selama 5 menit untuk mencegah penyimpanan berulang
                    Cache::put($cacheKey, true, now()->addMinutes(5));
                }
            }

            return $limit;
        });
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
    }
}
