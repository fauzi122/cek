<x-guest-layout>
    <div class="swiper-slide">

        <div class="slide-bg" style="background-image: url(./assets/images/bg-4.jpg);"></div>

    </div>
    <H1> <CEnter>HALAMAN LOGIN PENGAWAS UJIAN</CEnter></H1>
    <BR></BR>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <img src="{{ asset('assets_login/images/mybest_3.png') }}" alt="" height="70" class="me-1">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="Username" :value="__('NIP Dosen / NIM Mahasiswa')" />
            <x-text-input id="username" class="block mt-1 w-full" type="number" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />

        </div>

        <div class="mt-4">
            <x-input-label for="captcha_answer" :value="__('Jawab Pertanyaan Berikut:')" />
            <div class="mt-1 w-full">
                <p id="captcha_question">{{ $captcha['question'] }}</p>
                <x-text-input id="captcha_answer" class="block mt-1 w-full" type="number" name="captcha_answer" required oninvalid="this.setCustomValidity('Silakan jawab pertanyaan.')" oninput="setCustomValidity('')" />
                <x-input-error :messages="$errors->get('captcha_answer')" class="mt-2" />
            </div>
        </div>
        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif


            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>


    </form>
    <center>

        <br>
        <a class="text-theme-1" href="https://www.bsi.ac.id"><b>Universitas Bina Sarana Informatika </b><br>
            @php
            $hari_ini = date('Y-m-d');
            echo 'Hari ini. : '.dateIndonesia($hari_ini);
            echo '<br>IP : '.ambilIP();


            @endphp
        </a>

    </center>
</x-guest-layout>
@push('script')
// ... (kode lainnya) ...
<script>
    document.addEventListener("DOMContentLoaded", function() {
        generateCaptcha(); // Generate CAPTCHA on page load

        // Refresh CAPTCHA when the refresh button is clicked
        document.getElementById('refresh_captcha').addEventListener('click', function() {
            generateCaptcha();
        });

        function generateCaptcha() {
            var num1 = Math.floor(Math.random() * 10);
            var num2 = Math.floor(Math.random() * 10);
            var answer = num1 + num2;

            // Update question
            var captchaQuestion = "Berapa hasil dari " + num1 + " + " + num2 + "?";
            document.getElementById('captcha_question').innerText = captchaQuestion;
            document.getElementById('captcha_answer').value = answer;
        }
    });
</script>
// ... (kode lainnya) ...


@endpush