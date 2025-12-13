<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - CLPIS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Figtree', sans-serif; background: #f5f5f5; min-height: 100vh; }
        
        .page-wrapper { min-height: 100vh; display: flex; flex-direction: column; }
        
        /* Mobile Header */
        .page-header {
            background: linear-gradient(135deg, #A99066 0%, #8B7355 100%);
            padding: 40px 24px;
            text-align: center;
            color: white;
            border-radius: 0 0 32px 32px;
        }
        .page-header img {
            width: 64px; height: 64px;
            background: white; border-radius: 12px; padding: 8px;
            margin-bottom: 16px;
        }
        .page-header h1 { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { font-size: 13px; opacity: 0.9; }
        
        /* Form Container */
        .form-container {
            flex: 1; padding: 24px 20px;
            display: flex; align-items: flex-start; justify-content: center;
        }
        .form-card {
            width: 100%; max-width: 400px;
            background: white; border-radius: 16px;
            padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .form-card h2 { font-size: 20px; font-weight: 700; color: #1f2937; margin-bottom: 4px; }
        .form-card .subtitle { font-size: 14px; color: #6b7280; margin-bottom: 20px; line-height: 1.5; }
        
        /* Form Elements */
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .input-wrapper { position: relative; }
        .input-wrapper svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #9ca3af; }
        .input-wrapper input {
            width: 100%; padding: 12px 12px 12px 42px;
            border: 1px solid #d1d5db; border-radius: 10px;
            font-size: 14px; color: #1f2937;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-wrapper input:focus { outline: none; border-color: #A99066; box-shadow: 0 0 0 3px rgba(169,144,102,0.1); }
        .input-wrapper input::placeholder { color: #9ca3af; }
        
        /* Button */
        .submit-btn {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #A99066 0%, #8B7355 100%);
            color: white; font-size: 15px; font-weight: 600;
            border: none; border-radius: 10px; cursor: pointer;
            transition: opacity 0.2s;
            margin-top: 8px;
        }
        .submit-btn:hover { opacity: 0.9; }
        
        /* Links */
        .back-link { display: block; text-align: center; margin-top: 16px; font-size: 13px; color: #A99066; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
        
        /* Alerts */
        .error-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 12px; margin-bottom: 16px; }
        .error-box p { font-size: 13px; color: #dc2626; margin: 0; }
        .success-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px; margin-bottom: 16px; }
        .success-box p { font-size: 13px; color: #16a34a; margin: 0; }
        
        /* Desktop */
        @media (min-width: 1024px) {
            .page-wrapper { flex-direction: row; }
            .page-header { display: none; }
            .desktop-branding {
                display: flex !important; width: 50%;
                align-items: center; justify-content: center;
                background: linear-gradient(135deg, #A99066 0%, #8B7355 100%);
                padding: 48px;
            }
            .desktop-branding .content { text-align: center; color: white; max-width: 360px; }
            .desktop-branding img { width: 100px; height: 100px; background: white; border-radius: 16px; padding: 16px; margin-bottom: 24px; }
            .desktop-branding h1 { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
            .desktop-branding p { font-size: 14px; opacity: 0.9; line-height: 1.6; }
            .form-container { width: 50%; align-items: center; padding: 48px; }
            .form-card { padding: 32px; }
        }
        .desktop-branding { display: none; }
    </style>
</head>
<body>
    <div class="page-wrapper">
        
        {{-- Mobile Header --}}
        <div class="page-header">
            <img src="{{ asset('assets/images/logo1.png') }}" alt="CLPIS Logo">
            <h1>CLPIS</h1>
            <p>Construction Labor & Payroll System</p>
        </div>
        
        {{-- Desktop Left Branding --}}
        <div class="desktop-branding">
            <div class="content">
                <img src="{{ asset('assets/images/logo1.png') }}" alt="CLPIS Logo">
                <h1>CLPIS: Labor Management</h1>
                <p>Secure portal for time record management, payroll processing, and compliance reporting.</p>
            </div>
        </div>
        
        {{-- Form --}}
        <div class="form-container">
            <div class="form-card">
                <h2>Reset Password</h2>
                <p class="subtitle">Enter your email address and we'll send you a link to reset your password.</p>
                
                @if ($errors->any())
                    <div class="error-box">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                
                @if (session('status'))
                    <div class="success-box">
                        <p>{{ session('status') }}</p>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrapper">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                        </div>
                    </div>
                    
                    <button type="submit" class="submit-btn">Send Reset Link</button>
                    
                    <a href="{{ route('login') }}" class="back-link">← Back to Login</a>
                </form>
            </div>
        </div>
        
    </div>
</body>
</html>
