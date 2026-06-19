<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" type="text/css" href="{{ assetV('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetV('assets/css/bootstrap-icons.css') }}">
    <link rel="stylesheet" media="screen,print"
        href="{{ assetV('assets/components/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/components/validationEngine/jquery.validationEngine.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetV('assets/css/app.bundle.css') }}">
    <link rel="icon" type="image/png" href="{{ assetV('assets/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #0d9488;
            --primary-dark: #0f766e;
            --primary-rgb: 13, 148, 136;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background: #f8fafc;
            margin: 0;
            min-height: 100vh;
        }

        .login-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(145deg, #0f172a 0%, #134e4a 60%, #0d9488 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .06);
            top: -100px;
            left: -100px;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .06);
            bottom: -80px;
            right: -80px;
        }

        .login-left-inner {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 400px;
        }

        .login-left .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        .login-left .brand-icon {
            width: 44px;
            height: 44px;
            background: rgba(13, 148, 136, .3);
            border: 1px solid rgba(13, 148, 136, .5);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #5eead4;
        }

        .login-left .brand-text {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            letter-spacing: .5px;
        }

        .login-left .brand-text strong {
            color: #5eead4;
        }

        .login-illus {
            width: 100%;
            max-width: 360px;
            height: auto;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, .4));
            margin-bottom: 36px;
        }

        .login-left h2 {
            color: #fff;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .login-left p {
            color: #94a3b8;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
        }


        .login-right {
            width: 480px;
            flex-shrink: 0;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 56px;
            position: relative;
        }

        .login-right .top-logo {
            display: none;
            margin-bottom: 24px;
        }

        .login-right h1 {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .login-right .subtitle {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 32px;
        }

        .form-label-sm {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .input-group-custom {
            display: flex;
            align-items: center;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            transition: border-color .15s, box-shadow .15s;
            background: #fff;
        }

        .input-group-custom:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), .1);
        }

        .input-group-custom .ig-icon {
            width: 44px;
            height: 44px;
            background: #f8fafc;
            border-right: 1.5px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 16px;
            color: #94a3b8;
        }

        .input-group-custom input {
            flex: 1;
            border: none;
            outline: none;
            padding: 0 14px;
            font-size: 14px;
            font-family: inherit;
            color: #1e293b;
            background: transparent;
            height: 44px;
        }

        .input-group-custom input::placeholder {
            color: #cbd5e1;
        }

        .input-group-custom .ig-action {
            width: 44px;
            height: 44px;
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            transition: color .15s;
            font-size: 16px;
        }

        .input-group-custom .ig-action:hover {
            color: var(--primary);
        }

        .mb-field {
            margin-bottom: 18px;
        }

        .forgot-link {
            font-size: 12px;
            color: #64748b;
            text-decoration: none;
            float: right;
            transition: color .15s;
        }

        .forgot-link:hover {
            color: var(--primary);
        }

        .btn-login {
            width: 100%;
            height: 46px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background .15s, transform .1s;
            margin-top: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: var(--primary-dark);
        }

        .btn-login:active {
            transform: scale(.98);
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .login-footer {
            position: absolute;
            bottom: 20px;
            font-size: 11px;
            color: #cbd5e1;
            text-align: center;
        }

        @media (max-width: 768px) {
            .login-left {
                display: none;
            }

            .login-right {
                width: 100%;
                padding: 40px 24px;
            }

            .login-right .top-logo {
                display: block;
            }
        }
    </style>
    @yield('style')
</head>

<body>
    <div class="login-wrapper">

        <div class="login-left">
            <div class="login-left-inner">

                <div class="brand">
                    <div class="brand-icon"><i class="bi bi-x-lg"></i></div>
                    <span class="brand-text">Short <strong>link</strong></span>
                </div>

                <img src="{{ assetV('assets/image/warehouse.png') }}" alt="Warehouse Illustration" class="login-illus">

                {{-- <h2>ระบบจัดการคลังสินค้า</h2> --}}
                {{-- <p>บริหารจัดการสินค้าคงคลัง การรับ-จ่าย<br>และติดตามสถานะได้ทุกที่ทุกเวลา</p> --}}

            </div>
        </div>

        <div class="login-right">

            @yield('content')

            <div class="login-footer">
                © {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved
            </div>
        </div>

    </div>

    <script src="{{ assetV('assets/js/jquery.min.js') }}"></script>
    <script src="{{ assetV('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ assetV('assets/components/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ assetV('assets/components/validationEngine/languages/jquery.validationEngine-th.js') }}"></script>
    <script src="{{ assetV('assets/components/validationEngine/jquery.validationEngine.min.js') }}"></script>
    <script src="{{ assetV('assets/js/app.bundle.js') }}"></script>
    @yield('script')

</body>

</html>
