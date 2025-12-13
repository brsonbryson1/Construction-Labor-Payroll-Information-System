<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - CLPIS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Figtree', sans-serif; background: #f5f5f5; min-height: 100vh; }
        
        .login-wrapper { min-height: 100vh; display: flex; flex-direction: column; }
        
        /* Mobile Header */
        .login-header {
            background: linear-gradient(135deg, #A99066 0%, #8B7355 100%);
            padding: 40px 24px;
            text-align: center;
            color: white;
            border-radius: 0 0 32px 32px;
        }
        .login-header img {
            width: 64px; height: 64px;
            background: white; border-radius: 12px; padding: 8px;
            margin-bottom: 16px;
        }
        .login-header h1 { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .login-header p { font-size: 13px; opacity: 0.9; }
        
        /* Form Container */
        .login-form-container {
            flex: 1; padding: 24px 20px;
            display: flex; align-items: flex-start; justify-content: center;
        }
        .login-card {
            width: 100%; max-width: 400px;
            background: white; border-radius: 16px;
            padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .login-card h2 { font-size: 20px; font-weight: 700; color: #1f2937; margin-bottom: 4px; }
        .login-card .subtitle { font-size: 14px; color: #6b7280; margin-bottom: 24px; }
        
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
        
        /* Checkbox */
        .checkbox-group { display: flex; align-items: center; margin-bottom: 20px; }
        .checkbox-group input { width: 16px; height: 16px; accent-color: #A99066; margin-right: 8px; }
        .checkbox-group label { font-size: 13px; color: #6b7280; }
        
        /* Button */
        .login-btn {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #A99066 0%, #8B7355 100%);
            color: white; font-size: 15px; font-weight: 600;
            border: none; border-radius: 10px; cursor: pointer;
            transition: opacity 0.2s;
        }
        .login-btn:hover { opacity: 0.9; }
        
        /* Links */
        .forgot-link { display: block; text-align: center; margin-top: 16px; font-size: 13px; color: #A99066; text-decoration: none; }
        .forgot-link:hover { text-decoration: underline; }
        
        /* Footer */
        .login-footer { margin-top: 20px; padding-top: 16px; border-top: 1px solid #e5e7eb; text-align: center; font-size: 11px; color: #9ca3af; }
        
        /* Errors */
        .error-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 12px; margin-bottom: 16px; }
        .error-box p { font-size: 13px; color: #dc2626; margin: 0; }
        
        /* Desktop */
        @media (min-width: 1024px) {
            .login-wrapper { flex-direction: row; }
            .login-header { display: none; }
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
            .login-form-container { width: 50%; align-items: center; padding: 48px; }
            .login-card { padding: 32px; }
        }
        .desktop-branding { display: none; }
    </style>
</head>
<body>
    <div class="login-wrapper">
        
        {{-- Mobile Header --}}
        <div class="login-header">
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
        
        {{-- Login Form --}}
        <div class="login-form-container">
            <div class="login-card">
                <h2>Welcome Back</h2>
                <p class="subtitle">Sign in to your account</p>
                
                @if ($errors->any())
                    <div class="error-box">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                
                @if (session('status'))
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px; margin-bottom: 16px;">
                        <p style="font-size: 13px; color: #16a34a; margin: 0;">{{ session('status') }}</p>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrapper">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <input type="password" id="password" name="password" required placeholder="Enter your password">
                        </div>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    
                    <button type="submit" class="login-btn">Sign In</button>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot your password?</a>
                    @endif
                </form>
                
                <div class="login-footer">
                    This system is for authorized employees only.
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>
