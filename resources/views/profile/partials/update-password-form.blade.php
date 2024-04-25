<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman..') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" :value="__('kata sandi saat ini')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>
        

        <div>
            <x-input-label for="password" :value="__('kata sandi baru *minimal 8 karakter')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('konfirmasi sandi')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
<script>
    function updatePasswordStrength() {
      var passwordInput = document.getElementById("password");
      var passwordStrengthIndicator = document.getElementById("password-strength-indicator");
      var password = passwordInput.value;

      var hasLowerCase = /[a-z]/.test(password);
      var hasUpperCase = /[A-Z]/.test(password);
      var hasNumbers = /\d/.test(password);
      var hasSymbols = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(password);

      var strength = 0;
      if (password.length >= 8) strength++;
      if (hasLowerCase) strength++;
      if (hasUpperCase) strength++;
      if (hasNumbers) strength++;
      if (hasSymbols) strength++;

      var strengthText = "";
      if (strength === 0) {
          strengthText = "Lemah";
      } else if (strength < 4) {
          strengthText = "Sedang";
      } else {
          strengthText = "Kuat";
      }

      passwordStrengthIndicator.textContent = "Kekuatan Password: " + strengthText;
  }
  function togglePasswordVisibility(inputId) {
      var passwordInput = document.getElementById(inputId);
      var passwordIcon = document.getElementById("toggle" + inputId.charAt(0).toUpperCase() + inputId.slice(1) + "Icon");

      if (passwordInput.type === "password") {
          passwordInput.type = "text";
          passwordIcon.classList.remove("fa-eye");
          passwordIcon.classList.add("fa-eye-slash");
      } else {
          passwordInput.type = "password";
          passwordIcon.classList.remove("fa-eye-slash");
          passwordIcon.classList.add("fa-eye");
      }
  }
  </script>