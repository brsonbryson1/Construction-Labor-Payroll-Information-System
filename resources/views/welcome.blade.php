<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>CLPIS - Construction Labor & Payroll Information System</title>
    <meta name="description" content="Streamline your construction workforce management with CLPIS">
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#A99066">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/pwa/ios/180.png">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #ffffff;
            color: #1f2937;
            overflow-x: hidden;
        }
        
        /* Animated Background */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(169, 144, 102, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(169, 144, 102, 0.06) 0%, transparent 50%);
            z-index: 0;
            pointer-events: none;
        }
        
        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(169, 144, 102, 0.1);
            opacity: 0;
            transform: translateY(-20px);
            animation: slideDown 0.6s ease 0.2s forwards;
        }
        
        @keyframes slideDown {
            to { opacity: 1; transform: translateY(0); }
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        
        .logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #A99066 0%, #8B7355 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(169, 144, 102, 0.3);
        }
        
        .logo-icon img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }
        
        .logo-icon i {
            font-size: 22px;
            color: white;
        }
        
        .logo-text {
            font-size: 22px;
            font-weight: 800;
            color: #A99066;
        }
        
        /* Hero Section */
        .hero {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 100px 24px 60px;
            text-align: center;
        }
        
        .hero-content {
            max-width: 600px;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(169, 144, 102, 0.1);
            border: 1px solid rgba(169, 144, 102, 0.2);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 13px;
            color: #8B7355;
            margin-bottom: 24px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.6s ease 0.4s forwards;
        }
        
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
        
        .badge i {
            font-size: 14px;
            color: #A99066;
        }
        
        .hero h1 {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            color: #1f2937;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease 0.5s forwards;
        }
        
        .hero h1 span {
            background: linear-gradient(135deg, #A99066 0%, #8B7355 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero > .hero-content > p {
            font-size: 18px;
            color: #6b7280;
            line-height: 1.7;
            margin-bottom: 40px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease 0.6s forwards;
        }
        
        /* Buttons */
        .buttons {
            display: flex;
            flex-direction: column;
            gap: 16px;
            align-items: center;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease 0.7s forwards;
        }
        
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: linear-gradient(135deg, #A99066 0%, #8B7355 100%);
            color: white;
            padding: 18px 40px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            box-shadow: 0 8px 30px rgba(169, 144, 102, 0.35);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(169, 144, 102, 0.45);
        }
        
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: transparent;
            color: #6b7280;
            padding: 16px 32px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s;
            border: 1px solid #e5e7eb;
        }
        
        .btn-secondary:hover {
            color: #A99066;
            border-color: #A99066;
            background: rgba(169, 144, 102, 0.05);
        }
        
        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            animation: fadeUp 0.8s ease 1s forwards, bounce 2s ease-in-out 1.5s infinite;
        }
        
        .scroll-indicator i {
            font-size: 24px;
            color: #A99066;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(10px); }
        }
        
        /* Features Section */
        .features-section {
            position: relative;
            z-index: 1;
            padding: 80px 24px;
            background: #f9fafb;
        }
        
        .features-section .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-header h2 {
            font-size: 36px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 16px;
        }
        
        .section-header p {
            font-size: 18px;
            color: #6b7280;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        
        .feature-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 32px 24px;
            text-align: center;
            transition: all 0.3s;
        }
        
        .feature-card:hover {
            border-color: rgba(169, 144, 102, 0.3);
            box-shadow: 0 15px 40px rgba(169, 144, 102, 0.15);
            transform: translateY(-8px);
        }
        
        .feature-card .icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, rgba(169, 144, 102, 0.15) 0%, rgba(169, 144, 102, 0.08) 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .feature-card .icon i {
            font-size: 28px;
            color: #A99066;
        }
        
        .feature-card h3 {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 12px;
        }
        
        .feature-card p {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
        }
        
        /* Stats Section */
        .stats-section {
            position: relative;
            z-index: 1;
            padding: 60px 24px;
            background: linear-gradient(135deg, #A99066 0%, #8B7355 100%);
        }
        
        .stats-grid {
            max-width: 800px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            text-align: center;
        }
        
        .stat-item {
            color: white;
        }
        
        .stat-item .value {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        
        .stat-item .label {
            font-size: 13px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* CTA Section */
        .cta-section {
            position: relative;
            z-index: 1;
            padding: 80px 24px;
            text-align: center;
            background: #ffffff;
        }
        
        .cta-section h2 {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 16px;
        }
        
        .cta-section p {
            font-size: 18px;
            color: #6b7280;
            margin-bottom: 32px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Footer */
        .footer {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 24px;
            color: #9ca3af;
            font-size: 13px;
            border-top: 1px solid #f3f4f6;
            background: #f9fafb;
        }
        
        /* Intersection Observer Animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 12px 16px;
            }
            
            .logo-icon {
                width: 38px;
                height: 38px;
            }
            
            .logo-text {
                font-size: 18px;
            }
            
            .hero {
                padding: 80px 20px 40px;
                min-height: auto;
            }
            
            .hero h1 {
                font-size: 32px;
            }
            
            .hero > .hero-content > p {
                font-size: 16px;
            }
            
            .btn-primary {
                padding: 16px 32px;
                font-size: 15px;
                width: 100%;
            }
            
            .btn-secondary {
                width: 100%;
            }
            
            .scroll-indicator {
                display: none;
            }
            
            .features-section {
                padding: 60px 20px;
            }
            
            .section-header h2 {
                font-size: 28px;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }
            
            .stat-item .value {
                font-size: 28px;
            }
            
            .cta-section {
                padding: 60px 20px;
            }
            
            .cta-section h2 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <!-- Background -->
    <div class="bg-pattern"></div>

    <!-- Header -->
    <header class="header">
        <a href="/" class="logo">
            <div class="logo-icon">
                <img src="{{ asset('assets/images/logo1.png') }}" alt="CLPIS" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <i class="bi bi-building" style="display: none;"></i>
            </div>
            <span class="logo-text">CLPIS</span>
        </a>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="badge">
                <i class="bi bi-shield-check"></i>
                Trusted Payroll Management
            </div>
            
            <h1>Simplify Your <span>Construction Payroll</span></h1>
            
            <p>Streamline time tracking, attendance monitoring, and payroll processing for your construction workforce. All in one powerful platform.</p>
            
            <div class="buttons">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">
                            <i class="bi bi-grid-1x2-fill"></i> Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Employee Login
                        </a>
                    @endauth
                @endif
                <a href="#features" class="btn-secondary">
                    <i class="bi bi-arrow-down-circle"></i> Learn More
                </a>
            </div>
        </div>
        
        <div class="scroll-indicator">
            <i class="bi bi-chevron-double-down"></i>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Everything You Need</h2>
                <p>Comprehensive tools to manage your construction workforce efficiently</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card animate-on-scroll">
                    <div class="icon">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <h3>Time Tracking</h3>
                    <p>Easy clock in/out system with real-time monitoring and detailed time logs for accurate records.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <h3>Payroll Processing</h3>
                    <p>Automated calculations with overtime, deductions, and bonuses. Generate paystubs instantly.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="icon">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <h3>Attendance</h3>
                    <p>Monitor daily attendance, track absences, and manage schedules with complete visibility.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3>Employee Management</h3>
                    <p>Maintain complete employee records including personal info and payment history.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="icon">
                        <i class="bi bi-bar-chart-fill"></i>
                    </div>
                    <h3>Reports & Analytics</h3>
                    <p>Generate comprehensive reports on payroll, attendance, and workforce metrics.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3>Secure Access</h3>
                    <p>Role-based access control with Admin, Manager, and Employee permissions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item animate-on-scroll">
                <div class="value">100%</div>
                <div class="label">Accurate</div>
            </div>
            <div class="stat-item animate-on-scroll">
                <div class="value">24/7</div>
                <div class="label">Access</div>
            </div>
            <div class="stat-item animate-on-scroll">
                <div class="value">Fast</div>
                <div class="label">Processing</div>
            </div>
            <div class="stat-item animate-on-scroll">
                <div class="value">Secure</div>
                <div class="label">Data</div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="animate-on-scroll">
            <h2>Ready to Get Started?</h2>
            <p>Access your employee portal to manage time records, view paystubs, and stay updated.</p>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">
                        <i class="bi bi-grid-1x2-fill"></i> Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">
                        <i class="bi bi-box-arrow-in-right"></i> Employee Login
                    </a>
                @endauth
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>© {{ date('Y') }} CLPIS. Construction Labor & Payroll Information System</p>
    </footer>

    <!-- Scripts -->
    <script>
        // Intersection Observer for scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
        
        // PWA Service Worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js');
        }
    </script>
</body>
</html>