<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CLPIS - Welcome Portal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">

    {{-- Full-Screen Container to Center the Card --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        
        {{-- Custom Welcome Card (Compact and Simple) --}}
        <div class="w-full max-w-sm bg-white p-8 rounded-xl shadow-2xl text-center">
            
            {{-- 1. CLPIS Branding Header --}}
            <div class="flex flex-col items-center justify-center mb-6">
                {{-- Logo Image: Corrected path to assets/images/logo1.png --}}
                <div class="w-20 h-20 mb-3 flex items-center justify-center">
                    <img 
                        src="{{ asset('assets/images/logo1.png') }}" 
                        alt="CLPIS Logo: Construction Hard Hat" 
                        class="max-w-full max-h-full"
                        style="width: 80px; height: 80px;"
                    >
                </div>
                
                <h1 class="text-2xl font-bold text-gray-900">CLPIS</h1>
                <p class="text-sm text-gray-600">Your labor payroll companion</p>
                
                {{-- *** CHANGE APPLIED HERE *** --}}
                <p class="text-xs text-gray-400 mt-1">Construction Labor & Payroll Information System</p>
                {{-- The school name can be put in the footer/disclaimer if needed --}}
            </div>
            
            <hr class="mb-6 border-gray-200">
            
            {{-- 2. Navigation Buttons --}}
            <div class="space-y-4">
                @if (Route::has('login'))
                    @auth
                        {{-- If User is Logged In --}}
                        <a href="{{ url('/dashboard') }}" class="w-full block py-3 px-4 text-white font-semibold rounded-lg shadow-md transition-all duration-200" style="background: linear-gradient(135deg, #A99066 0%, #8B7355 100%);">
                            Go to Dashboard
                        </a>
                    @else
                        {{-- Login Button (Primary color - Brown theme) --}}
                        <a href="{{ route('login') }}" class="w-full block py-3 px-4 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 hover:opacity-90" style="background: linear-gradient(135deg, #A99066 0%, #8B7355 100%);">
                            Employee Login
                        </a>
                    @endauth
                @endif
            </div>

            <p class="mt-6 text-xs text-gray-500">
            Authorized Personnel Access Only. Time and Payroll Management System.
            </p>
            
        </div>
    </div>
</body>
</html>