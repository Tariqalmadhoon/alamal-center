<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'نظام إدارة الأيتام') - مركز الأمل</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: #0F5132;
            --accent-green: #059669;
            --light-green: #10b981;
            --white: #ffffff;
            --off-white: #f8fafc;
            --light-gray: #f1f5f9;
            --border-gray: #e2e8f0;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --danger: #dc2626;
            --warning: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--off-white);
            color: var(--text-dark);
            line-height: 1.6;
            direction: rtl;
            min-height: 100vh;
        }

        /* ============ HEADER ============ */
        .header {
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            color: white;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(15, 81, 50, 0.3);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .header-title {
            font-size: 20px;
            font-weight: 800;
        }

        .header-subtitle {
            font-size: 11px;
            opacity: 0.9;
        }

        .header-stats {
            display: flex;
            gap: 20px;
        }

        .stat-box {
            text-align: center;
            padding: 8px 20px;
            background: rgba(255,255,255,0.15);
            border-radius: 8px;
        }

        .stat-number {
            font-size: 22px;
            font-weight: 800;
        }

        .stat-label {
            font-size: 11px;
            opacity: 0.9;
        }

        /* ============ MAIN CONTENT ============ */
        .main-content {
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* ============ ALERTS ============ */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border: 1px solid #86efac;
            color: #166534;
        }

        .alert-error {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border: 1px solid #fca5a5;
            color: #991b1b;
        }

        /* ============ CARDS ============ */
        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .card-header {
            padding: 20px 25px;
            background: linear-gradient(135deg, rgba(15, 81, 50, 0.03), rgba(5, 150, 105, 0.02));
            border-bottom: 1px solid var(--border-gray);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-green);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 25px;
        }

        /* ============ BUTTONS ============ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            color: white;
            box-shadow: 0 4px 15px rgba(15, 81, 50, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(15, 81, 50, 0.4);
        }

        .btn-secondary {
            background: var(--light-gray);
            color: var(--text-dark);
        }

        .btn-secondary:hover {
            background: var(--border-gray);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }

        .btn-icon {
            padding: 8px;
            border-radius: 8px;
        }

        /* ============ FORMS ============ */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-label.required::after {
            content: ' *';
            color: var(--danger);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            font-size: 14px;
            border: 2px solid var(--border-gray);
            border-radius: 10px;
            font-family: 'Cairo', sans-serif;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-green);
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
        }

        .form-control.error {
            border-color: var(--danger);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        select.form-control {
            cursor: pointer;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .form-error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 5px;
        }

        /* ============ FILE UPLOAD ============ */
        .file-upload {
            border: 2px dashed var(--border-gray);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--light-gray);
        }

        .file-upload:hover {
            border-color: var(--accent-green);
            background: rgba(5, 150, 105, 0.05);
        }

        .file-upload input {
            display: none;
        }

        .file-upload-icon {
            width: 50px;
            height: 50px;
            fill: var(--text-gray);
            margin-bottom: 10px;
        }

        .file-upload-text {
            color: var(--text-gray);
            font-size: 14px;
        }

        .file-preview {
            margin-top: 15px;
        }

        .file-preview img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid var(--accent-green);
        }

        /* ============ TABLE ============ */
        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: right;
            border-bottom: 1px solid var(--border-gray);
        }

        .table th {
            background: var(--light-gray);
            font-weight: 700;
            color: var(--primary-green);
            font-size: 13px;
        }

        .table tr:hover {
            background: rgba(5, 150, 105, 0.03);
        }

        .table-photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent-green);
        }

        .table-actions {
            display: flex;
            gap: 8px;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-male {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-female {
            background: #fce7f3;
            color: #be185d;
        }

        /* ============ SECTION DIVIDER ============ */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-green);
        }

        .section-divider-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-divider-icon svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        .section-divider-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-green);
        }

        /* ============ SEARCH ============ */
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-input {
            flex: 1;
            max-width: 400px;
        }

        /* ============ EMPTY STATE ============ */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-gray);
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            fill: var(--border-gray);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 18px;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        /* ============ PAGINATION ============ */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 14px;
            text-decoration: none;
            color: var(--text-dark);
            background: white;
            border: 1px solid var(--border-gray);
        }

        .pagination a:hover {
            background: var(--light-gray);
        }

        .pagination .active span {
            background: var(--primary-green);
            color: white;
            border-color: var(--primary-green);
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .header-stats {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .main-content {
                padding: 15px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }

            .documents-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ============ DOCUMENTS GRID ============ */
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .documents-grid .form-group {
            margin-bottom: 0;
            display: flex;
            flex-direction: column;
        }

        .documents-grid .form-group .form-label {
            margin-bottom: 10px;
        }

        .documents-grid .doc-current-image {
            text-align: center;
            margin-bottom: 10px;
            padding: 10px;
            background: var(--light-gray);
            border-radius: 8px;
            border: 2px solid var(--border-gray);
        }

        .documents-grid .doc-current-image img {
            max-width: 120px;
            max-height: 120px;
            object-fit: contain;
            border-radius: 6px;
            border: 2px solid var(--accent-green);
        }

        .documents-grid .doc-current-image p {
            font-size: 11px;
            color: var(--text-gray);
            margin-top: 5px;
        }

        .documents-grid .file-upload {
            flex: 1;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .documents-grid .file-upload-icon {
            width: 35px;
            height: 35px;
            margin-bottom: 8px;
        }

        .documents-grid .file-upload-text {
            font-size: 12px;
        }

        .documents-grid .file-preview img {
            max-width: 100px;
            max-height: 100px;
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

        @media (max-width: 768px) {
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
    <header class="header">
        <div class="header-brand">
            <img src="{{ asset('logo_alamal.png') }}" alt="شعار مركز الأمل" class="header-logo">
            <div>
                <h1 class="header-title">مركز الأمل للتنمية ورعاية الأيتام</h1>
                <p class="header-subtitle">AL-AMAL CENTER FOR DEVELOPMENT & ORPHAN CARE</p>
            </div>
        </div>
        <div class="header-stats">
            <div class="stat-box">
                <div class="stat-number">{{ \App\Models\Orphan::count() }}</div>
                <div class="stat-label">إجمالي الأيتام</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ \App\Models\Orphan::where('gender', 'male')->count() }}</div>
                <div class="stat-label">ذكور</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ \App\Models\Orphan::where('gender', 'female')->count() }}</div>
                <div class="stat-label">إناث</div>
            </div>
        </div>
    </header>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
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
