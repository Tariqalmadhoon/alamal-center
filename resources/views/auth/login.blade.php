<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تسجيل الدخول - مركز الأمل لتنمية ورعاية الأيتام</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #059669;
            --dark-green: #047857;
            --light-green: #10b981;
            --accent-green: #34d399;
            --bg-gradient-start: #064e3b;
            --bg-gradient-end: #047857;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 50%, var(--primary-green) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Elements */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: float 15s infinite ease-in-out;
        }

        .shape:nth-child(1) { width: 300px; height: 300px; top: -100px; right: -100px; animation-delay: 0s; }
        .shape:nth-child(2) { width: 200px; height: 200px; bottom: -50px; left: -50px; animation-delay: 3s; }
        .shape:nth-child(3) { width: 150px; height: 150px; top: 50%; left: 10%; animation-delay: 6s; }
        .shape:nth-child(4) { width: 100px; height: 100px; top: 20%; right: 20%; animation-delay: 9s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.5; }
            50% { transform: translateY(-30px) rotate(180deg); opacity: 0.8; }
        }

        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 450px;
            z-index: 1;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            padding: 50px 40px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Logo Section */
        .logo-section {
            text-align: center;
            
        }

        .logo-circle {
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(5, 150, 105, 0.4);
            animation: pulse 2s infinite;
            overflow: hidden;
            padding: 8px;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 10px 30px rgba(5, 150, 105, 0.4); }
            50% { transform: scale(1.05); box-shadow: 0 15px 40px rgba(5, 150, 105, 0.5); }
        }

        .logo-circle img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .logo-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--dark-green);
            margin-bottom: 5px;
        }

        .logo-subtitle {
            font-size: 14px;
            color: #6b7280;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 18px;
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Cairo', sans-serif;
            transition: all 0.3s ease;
            direction: rtl;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-green);
            background: white;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .form-input.error {
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
        }

        /* Remember & Forgot */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-green);
            cursor: pointer;
        }

        .remember-me span {
            font-size: 14px;
            color: #4b5563;
        }

        .forgot-link {
            font-size: 14px;
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: var(--dark-green);
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            font-family: 'Cairo', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.4);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.5);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .login-footer p {
            font-size: 13px;
            color: #9ca3af;
        }

        /* Session Status */
        .session-status {
            background: #d1fae5;
            color: #047857;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 35px 25px;
            }
            
            .logo-circle {
                width: 80px;
                height: 80px;
            }
            
            .logo-title {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo-circle">
                    <img src="{{ asset('logo_alamal.png') }}" alt="شعار مركز الأمل">
                </div>
                <h1 class="logo-title">مركز الأمل لتنمية ورعاية الأيتام</h1>
                <p class="logo-subtitle">نظام إدارة ملفات الأيتام</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="session-status">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label" for="email">البريد الإلكتروني</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input @error('email') error @enderror" 
                        value="{{ old('email') }}"
                        placeholder="أدخل بريدك الإلكتروني"
                        required 
                        autofocus
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="password">كلمة المرور</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input @error('password') error @enderror"
                        placeholder="أدخل كلمة المرور"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <span>تذكرني</span>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" class="submit-btn">
                    تسجيل الدخول
                </button>
            </form>

            <!-- Footer -->
            <div class="login-footer">
                <p>© {{ date('Y') }} مركز الأمل - جميع الحقوق محفوظة</p>
            </div>
        </div>
    </div>

    <h1>تجربة </h1>
</body>
</html>
