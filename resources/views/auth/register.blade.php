<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    
    <!-- Google Register Button -->
    <div class="mt-6 flex justify-center">
        <a href="{{ route('google.login') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 w-full justify-center"
        >
            <svg class="h-5 w-5 mr-2" viewBox="0 0 48 48">
                <g>
                    <path d="M44.5 20H24v8.5h11.7C34.4 33.1 29.7 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c2.8 0 5.3.9 7.3 2.5l6.7-6.7C34.5 5.1 29.5 3 24 3 12.9 3 4 11.9 4 23s8.9 20 20 20c11.1 0 20-8.9 20-20 0-1.3-.1-2.7-.4-4z" fill="#FFC107"/>
                    <path d="M6.3 14.7l7 5.1C15 17.1 18.2 15 24 15c2.8 0 5.3.9 7.3 2.5l6.7-6.7C34.5 5.1 29.5 3 24 3c-7 0-13 4.3-16 10.7z" fill="#FF3D00"/>
                    <path d="M24 43c5.3 0 10.2-1.8 13.8-5l-6.4-5.2c-2 1.4-4.7 2.2-7.4 2.2-5.7 0-10.5-3.9-12.2-9.1l-7 5.4C6.5 39.7 14.6 43 24 43z" fill="#4CAF50"/>
                    <path d="M44.5 20H24v8.5h11.7c-1.2 3.4-4.6 6.5-11.7 6.5-5.7 0-10.5-3.9-12.2-9.1l-7 5.5C6.5 39.7 14.6 43 24 43c7.5 0 14-2.5 18.2-7 0-1.2 0-2.4-.1-3.6z" fill="#1976D2"/>
                </g>
            </svg>
            <span>Sign up with Google</span>
        </a>
    </div>
</x-guest-layout>
