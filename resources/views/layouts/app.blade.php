<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'نظام إدارة الأيتام') - مركز الأمل</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #059669;
            --dark-green: #047857;
            --light-green: #10b981;
            --accent-green: #34d399;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --light-gray: #f3f4f6;
            --border-gray: #e5e7eb;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: #f8fafc;
            min-height: 100vh;
            color: var(--text-dark);
        }

        /* ============ HEADER ============ */
        .main-header {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(5, 150, 105, 0.3);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-logo {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            overflow: hidden;
            padding: 4px;
        }

        .brand-logo img {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }

        .brand-info h1 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .brand-info p {
            font-size: 12px;
            opacity: 0.9;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            text-align: left;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.15);
            padding: 8px 15px;
            border-radius: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar svg {
            width: 24px;
            height: 24px;
            fill: var(--primary-green);
        }

        .user-details {
            text-align: right;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
        }

        .user-role {
            font-size: 11px;
            opacity: 0.85;
            background: rgba(255,255,255,0.2);
            padding: 2px 8px;
            border-radius: 10px;
            display: inline-block;
        }

        .logout-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            font-family: 'Cairo', sans-serif;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }

        .logout-btn svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        /* ============ MAIN CONTENT ============ */
        .main-content {
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* ============ PAGE HEADER ============ */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-dark);
        }

        .header-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ============ BUTTONS ============ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Cairo', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            color: white;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
        }

        .btn-secondary {
            background: var(--light-gray);
            color: var(--text-dark);
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        /* ============ CONTENT CARD ============ */
        .content-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        /* ============ FORM STYLES ============ */
        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .form-row { grid-template-columns: 1fr; }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-label.required::after {
            content: ' *';
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: var(--light-gray);
            border: 2px solid var(--border-gray);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Cairo', sans-serif;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-green);
            background: white;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
        }

        .form-control.error {
            border-color: #ef4444;
        }

        .form-error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-gray);
        }

        /* ============ SECTION DIVIDER ============ */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 30px 0 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--light-gray);
        }

        .section-divider-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-divider-icon svg {
            width: 22px;
            height: 22px;
            fill: white;
        }

        .section-divider-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
        }

        /* ============ FILE UPLOAD ============ */
        .file-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 25px;
            background: var(--light-gray);
            border: 2px dashed var(--border-gray);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .file-upload:hover {
            border-color: var(--primary-green);
            background: rgba(5, 150, 105, 0.05);
        }

        .file-upload input[type="file"] {
            display: none;
        }

        .file-upload-icon {
            width: 40px;
            height: 40px;
            fill: var(--primary-green);
            margin-bottom: 10px;
        }

        .file-upload-text {
            font-size: 13px;
            color: var(--text-gray);
        }

        /* ============ TABLE ============ */
        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 15px;
            text-align: right;
            border-bottom: 1px solid var(--border-gray);
        }

        .data-table th {
            background: var(--light-gray);
            font-weight: 700;
            color: var(--text-dark);
            font-size: 13px;
        }

        .data-table tbody tr:hover {
            background: #f9fafb;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light-gray);
            color: var(--text-dark);
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-icon:hover {
            background: var(--primary-green);
            color: white;
        }

        .btn-icon.btn-danger:hover {
            background: #ef4444;
        }

        /* ============ ALERTS ============ */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #d1fae5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* ============ DOCUMENTS GRID ============ */
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @media (max-width: 768px) {
            .documents-grid { grid-template-columns: 1fr; }
        }

        .documents-grid .form-group {
            margin-bottom: 0;
        }

        .documents-grid .file-upload {
            padding: 20px 15px;
            min-height: 120px;
        }

        .doc-current-image {
            text-align: center;
            padding: 10px;
            background: var(--light-gray);
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .doc-current-image img {
            max-width: 120px;
            max-height: 80px;
            border-radius: 6px;
            border: 2px solid var(--accent-green);
        }

        .doc-current-image p {
            font-size: 11px;
            color: var(--text-gray);
            margin-top: 5px;
        }

        /* ============ PHOTO UPLOAD ============ */
        .photo-upload-container {
            display: flex;
            gap: 20px;
            align-items: stretch;
        }

        .current-photo {
            text-align: center;
            padding: 15px;
            background: var(--light-gray);
            border-radius: 10px;
            border: 2px solid var(--border-gray);
            min-width: 140px;
        }

        .current-photo img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            border: 3px solid var(--accent-green);
        }

        .current-photo p {
            font-size: 11px;
            color: var(--text-gray);
            margin-top: 8px;
        }

        .photo-upload-box {
            flex: 1;
            max-width: 300px;
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 768px) {
            .main-header {
                padding: 15px;
                flex-direction: column;
                gap: 15px;
            }
            
            .header-user {
                width: 100%;
                justify-content: space-between;
            }
            
            .main-content {
                padding: 20px;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .photo-upload-container {
                flex-direction: column;
            }
            
            .photo-upload-box {
                max-width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="header-brand">
            <div class="brand-logo">
                <img src="{{ asset('logo_alamal.png') }}" alt="شعار مركز الأمل">
            </div>
            <div class="brand-info">
                <h1>مركز الأمل لتنمية ورعاية الأيتام</h1>
                <p>نظام إدارة ملفات الأيتام</p>
            </div>
        </div>
        
        @auth
        <div class="header-user">
            <div class="user-info">
                <div class="user-avatar">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="user-details">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <span class="user-role">{{ Auth::user()->role_name }}</span>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg viewBox="0 0 24 24">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                    تسجيل الخروج
                </button>
            </form>
        </div>
        @endauth
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                <svg viewBox="0 0 24 24" width="20" height="20" style="fill: currentColor;">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg viewBox="0 0 24 24" width="20" height="20" style="fill: currentColor;">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
