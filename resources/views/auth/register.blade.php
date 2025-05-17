<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="bg-blue-50 p-8 rounded-lg shadow-md">
        @csrf

        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-blue-800">Create Account</h2>
            <p class="text-blue-600 text-sm mt-1">Join our laundry management system</p>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-blue-800" />
            <x-text-input id="name" class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500" 
                         type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-blue-700" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-blue-800" />
            <x-text-input id="email" class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500" 
                         type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-blue-700" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-blue-800" />

            <x-text-input id="password" class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-blue-700" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-blue-800" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-blue-700" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        
        <div class="text-center mt-6 pt-4 border-t border-blue-100">
            <p class="text-sm text-blue-700">
                {{ __('Already have an account?') }} 
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">
                    {{ __('Sign in') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
