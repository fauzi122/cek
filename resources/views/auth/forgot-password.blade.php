<x-guest-layout>
    <center>
        <div class="avatar sm">
            <img src="{{ asset('assets_login/images/mybest_3.png') }}" class="circle" style="width:240px;height:100px;" alt="biAdmin"/>
    </div>
    <br>
</center>
    <p>
        <p>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('lupa kata sandi Anda? masukan alamat email Anda yang terdaftar pada sistem dan kami akan mengirimkan email berisi tautan pengaturan ulang kata sandi atau dapat dibantu KK/SO/ADM Cabang untuk mereset Password anda.') }}
    </div>
    <b  class="text-2xl"> *catatan : silahkan cek spam / inbox pada email anda</b>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
