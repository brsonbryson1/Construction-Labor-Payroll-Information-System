<x-guest-layout>
    {{-- This component creates the main white, rounded card container --}}
    <x-authentication-card>
        
        {{-- Custom Header Slot: Branding and Title (CORRECTED LOGO DISPLAY) --}}
        <x-slot name="logo">
            <div class="flex flex-col items-center justify-center">
                {{-- Logo Image: Corrected path to assets/images/logo1.png --}}
                <div class="w-20 h-20 mb-3 mx-auto flex items-center justify-center">
                    <img 
                        src="{{ asset('assets/images/logo1.png') }}" 
                        alt="CLPIS Logo: Construction Hard Hat" 
                        class="max-w-full max-h-full"
                        style="width: 80px; height: 80px;"
                    >
                </div>
                
                <h1 class="text-xl font-bold mb-1 text-gray-800">CLPIS</h1>
                <p class="text-sm text-gray-600 mb-4">Employee Registration</p>
            </div>
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- 1. Full Name Field --}}
            <div class="mb-4">
                <x-label for="name" value="{{ __('Full Name') }}" class="mb-1" />
                <div class="relative">
                    {{-- Icon for Name --}}
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14s-2 3-5 3-5 3-5 3h14c0 0-2-3-5-3s-5-3-5-3z" />
                        </svg>
                    </div>
                    {{-- Input Field --}}
                    <x-input id="name" class="block ps-10 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter Full Name" />
                </div>
            </div>

            {{-- 2. Email / Employee ID Field --}}
            <div class="mt-4 mb-4">
                <x-label for="email" value="{{ __('Email or Employee ID') }}" class="mb-1" />
                <div class="relative">
                    {{-- Icon for Email --}}
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.8 5.2a2 2 0 002.4 0L21 8m-2 4v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7m16-4V7a2 2 0 00-2-2H5a2 2 0 00-2 2v1" />
                        </svg>
                    </div>
                    {{-- Input Field --}}
                    <x-input id="email" class="block ps-10 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter Company Email or Employee ID" />
                </div>
            </div>

            {{-- 3. Password Field --}}
            <div class="mt-4 mb-4">
                <x-label for="password" value="{{ __('Password') }}" class="mb-1" />
                <div class="relative">
                    {{-- Icon for Password --}}
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6-4h12M12 9V7m-1 8h2a2 2 0 002-2V9a2 2 0 00-2-2h-2a2 2 0 00-2 2v4a2 2 0 002 2z" />
                        </svg>
                    </div>
                    {{-- Input Field --}}
                    <x-input id="password" class="block ps-10 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Create Password" />
                </div>
            </div>

            {{-- 4. Confirm Password Field --}}
            <div class="mt-4 mb-6">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="mb-1" />
                <div class="relative">
                    {{-- Icon for Confirm Password --}}
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6-4h12M12 9V7m-1 8h2a2 2 0 002-2V9a2 2 0 00-2-2h-2a2 2 0 00-2 2v4a2 2 0 002 2z" />
                        </svg>
                    </div>
                    {{-- Input Field --}}
                    <x-input id="password_confirmation" class="block ps-10 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" />
                </div>
            </div>
            
            {{-- Terms and Policy (Keep this block if you are using Jetstream features) --}}
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2 text-xs">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            {{-- Registration Button and Login Link --}}
            <div class="flex items-center justify-end mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                {{-- Custom Button Styling: Match the primary button color from your design (purple/indigo) --}}
                <x-button class="ms-4 bg-indigo-600 hover:bg-indigo-700">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>