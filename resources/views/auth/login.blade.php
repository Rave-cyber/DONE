<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-blue-50 p-8 rounded-lg shadow-md">
        @csrf

        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-blue-800">Welcome Back</h2>
            <p class="text-blue-600 text-sm mt-1">Sign in to your account</p>
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-blue-800" />
            <x-text-input id="email" class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500" 
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-blue-700" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-blue-800" />
            <x-text-input id="password" class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-blue-700" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" 
                       class="rounded border-blue-300 text-blue-600 shadow-sm focus:ring-blue-500" 
                       name="remember">
                <span class="ms-2 text-sm text-blue-700">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 hover:underline" 
                   href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
                {{ __('Sign In') }}
            </x-primary-button>
        </div>
        
        @if (Route::has('register'))
            <div class="text-center mt-6 pt-4 border-t border-blue-100">
                <p class="text-sm text-blue-700">
                    {{ __("Don't have an account?") }} 
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline">
                        {{ __('Create one now') }}
                    </a>
                </p>
            </div>
        @endif
    </form>
</x-guest-layout>