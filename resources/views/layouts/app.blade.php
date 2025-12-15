<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CLPIS') }}</title>

    {{-- PWA Meta Tags --}}
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#A99066">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="CLPIS">
    <link rel="apple-touch-icon" href="/pwa/ios/180.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/pwa/ios/152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/pwa/ios/180.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/pwa/ios/167.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Figtree', sans-serif; }
        
        /* Preloader */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #ffffff;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s ease;
        }
        #preloader.fade-out {
            opacity: 0;
            pointer-events: none;
        }
        .loader {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #A99066;
            border-radius: 50%;
            animation: loader-spin 0.8s linear infinite;
        }
        @keyframes loader-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Layout */
        .app-container { display: flex; min-height: 100vh; background: #f3f4f6; }
        .main-wrapper { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 256px;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            z-index: 50;
            display: flex;
            flex-direction: column;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        .sidebar.open { transform: translateX(0); }
        
        /* Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 40;
        }
        .sidebar-overlay.active { display: block; }
        
        /* Header */
        .top-header {
            height: 64px;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            position: sticky;
            top: 0;
            z-index: 30;
        }
        
        /* Main content */
        .main-content { flex: 1; padding: 16px; overflow-x: hidden; }
        
        /* Desktop only - hidden on mobile */
        .desktop-only { display: none; }
        
        /* Mobile only */
        .mobile-only { display: block; }
        
        /* Desktop styles */
        @media (min-width: 1024px) {
            .sidebar { transform: translateX(0); }
            .main-wrapper { margin-left: 256px; }
            .main-content { padding: 24px; }
            .mobile-only { display: none !important; }
            .desktop-only { display: block !important; }
        }
        
        /* Buttons */
        .btn-primary {
            background: #A99066;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary:hover { background: #8B7355; }
        
        .menu-btn {
            padding: 8px;
            background: none;
            border: none;
            font-size: 24px;
            color: #4b5563;
            cursor: pointer;
        }
    </style>
</head>
<body>
    {{-- Preloader --}}
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <x-banner />

    {{-- Overlay --}}
    <div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

    <div class="app-container">
        {{-- Sidebar --}}
        @include('components.nav-sidemenu')

        {{-- Main Content --}}
        <div class="main-wrapper">
            {{-- Top Header --}}
            <header class="top-header">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <button class="menu-btn mobile-only" id="sidebar-toggle" type="button">
                        <i class="bi bi-list"></i>
                    </button>
                    <h1 style="font-size: 16px; font-weight: 600; color: #374151; margin: 0;">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>

                <div style="display: flex; align-items: center; gap: 8px;">
                    <a href="{{ route('profile.show') }}" style="display: flex; align-items: center; gap: 8px; color: #374151; text-decoration: none; padding: 8px;">
                        <i class="bi bi-person-circle" style="font-size: 20px;"></i>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-primary">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </header>
            
            {{-- Main Content Area --}}
            <main class="main-content">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            setTimeout(function() {
                preloader.classList.add('fade-out');
                setTimeout(function() {
                    preloader.style.display = 'none';
                }, 300);
            }, 500);
        });

        // Sidebar
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleBtn = document.getElementById('sidebar-toggle');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        toggleBtn?.addEventListener('click', function() {
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    </script>

    @stack('modals')
    @livewireScripts
    
    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
