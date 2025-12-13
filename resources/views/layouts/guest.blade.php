<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CLPIS') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
        
        <style>
            /* Mobile-first login styles */
            .login-container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }
            
            /* Mobile: Brown header banner */
            .mobile-header {
                display: block;
                background: linear-gradient(135deg, #A99066 0%, #8B7355 100%);
                padding: 32px 24px;
                text-align: center;
                color: white;
            }
            
            .mobile-header img {
                width: 60px;
                height: 60px;
                background: white;
                border-radius: 12px;
                padding: 8px;
                margin-bottom: 12px;
            }
            
            .mobile-header h1 {
                font-size: 18px;
                font-weight: 700;
                margin: 0 0 4px 0;
            }
            
            .mobile-header p {
                font-size: 12px;
                opacity: 0.9;
                margin: 0;
            }
            
            /* Mobile: Form area */
            .mobile-form-area {
                flex: 1;
                display: flex;
                align-items: flex-start;
                justify-content: center;
                padding: 24px 20px;
                background: #f9fafb;
            }
            
            .mobile-form-area > div {
                width: 100%;
                max-width: 400px;
            }
            
            /* Desktop: Split screen */
            @media (min-width: 1024px) {
                .mobile-header {
                    display: none;
                }
                
                .login-container {
                    flex-direction: row;
                }
                
                .desktop-branding {
                    display: flex !important;
                    width: 50%;
                    align-items: center;
                    justify-content: center;
                    padding: 48px;
                    background-color: #A99066;
                }
                
                .mobile-form-area {
                    width: 50%;
                    align-items: center;
                    padding: 48px;
                }
            }
            
            .desktop-branding {
                display: none;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            
            {{-- Mobile Header Banner --}}
            <div class="mobile-header">
                <img src="{{ asset('assets/images/logo1.png') }}" alt="CLPIS Logo">
                <h1>CLPIS: Labor Management</h1>
                <p>Construction Labor & Payroll System</p>
            </div>

            {{-- Desktop Left Side Branding --}}
            <div class="desktop-branding">
                <div class="text-white max-w-sm text-center">
                    <div class="bg-white rounded-lg p-6 inline-block mb-6 shadow-xl" style="clip-path: polygon(10% 0, 90% 0, 100% 10%, 100% 90%, 90% 100%, 10% 100%, 0 90%, 0 10%);">
                        <img src="{{ asset('assets/images/logo1.png') }}" alt="CLPIS Logo" style="width: 100px; height: 100px;">
                    </div>
                    <p class="text-sm tracking-widest font-medium mb-1 uppercase" style="color: #EEEEEE;">
                        CONSTRUCTION & LABOR OFFICE
                    </p>
                    <h1 class="text-2xl font-extrabold mb-2">
                        CLPIS: Labor Management System
                    </h1>
                    <p class="text-sm opacity-90 leading-relaxed">
                        Secure portal for time record management, payroll processing, and compliance reporting.
                    </p>
                </div>
            </div>

            {{-- Form Area --}}
            <div class="mobile-form-area">
                <div class="font-sans text-gray-900 antialiased">
                    {{ $slot }}
                </div>
            </div>

        </div>
        @livewireScripts
    </body>
</html>
