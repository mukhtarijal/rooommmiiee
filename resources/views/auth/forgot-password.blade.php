<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Lupa kata sandi Anda? Tidak masalah. Beri tahu kami alamat email Anda, dan kami akan mengirimkan link reset kata sandi yang memungkinkan Anda memilih kata sandi baru.') }}
    </div>

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

        <div class="flex items-center justify-between mt-4">
            <!-- Link Back to Login -->
            <a href="{{ route('login') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                {{ __('Kembali ke Login') }}
            </a>

            <!-- Submit Button -->
            <x-primary-button>
                {{ __('Kirim Link Reset Kata Sandi') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
