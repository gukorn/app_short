<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" type="text/css" href="{{ assetV('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetV('assets/css/bootstrap-icons.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #fafbfc;
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-column: column;
            flex-direction: column;
        }

        .text-teal { color: #398276; }
        .bg-teal { background-color: #398276; color: white; }
        .bg-teal:hover { background-color: #2d665d; color: white; }
        .bg-teal-light { background-color: #eaf5f2; }

        .top-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 24px;
        }
        .top-tabs .tab-item {
            color: #64748b;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .top-tabs .tab-item:hover, .top-tabs .tab-item.active {
            color: #398276;
            background-color: #eaf5f2;
        }
        .hover-teal:hover {
            color: #398276 !important;
        }
        .btn-outline-teal {
            border: 1px solid #398276;
            color: #398276;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 6px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-outline-teal:hover {
            background-color: #398276;
            color: white;
        }

        .main-content-wrapper {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .landing-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(57, 130, 118, 0.04);
            padding: 40px;
            width: 100%;
            max-width: 550px;
            text-align: center;
        }

        .form-label-custom {
            font-weight: 500;
            color: #475569;
            margin-bottom: 6px;
            font-size: 0.85rem;
            text-align: left;
            display: block;
        }
        .form-control-custom {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .form-control-custom:focus {
            border-color: #398276;
            box-shadow: 0 0 0 3px rgba(57, 130, 118, 0.15);
            outline: none;
        }
        .icon-header-box {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
            font-size: 1.5rem;
        }
    </style>
    @yield('style')
</head>
<body>

    <div class="top-navbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-4">
            <a href="#" class="text-decoration-none d-flex align-items-center gap-2">
                <div class="bg-teal d-flex align-items-center justify-content-center rounded-2" style="width: 32px; height: 32px;">
                    <i class="bi bi-box-seam" style="font-size: 1rem;"></i>
                </div>
                <span class="fw-bold text-dark" style="font-size: 1.05rem; letter-spacing: -0.5px;">Short link</span>
            </a>

            <div class="top-tabs d-none d-md-flex gap-1">
                <a href="#" class="tab-item active">หน้าแรก</a>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="{{ actionURL('Auth\LoginController@showLoginForm') }}" class="text-secondary text-decoration-none fw-medium hover-teal" style="font-size: 0.85rem;">
                <i class="bi bi-box-arrow-in-right me-1"></i> เข้าระบบ
            </a>
            <span class="text-muted opacity-25">|</span>
            <a href="{{ actionURL('Auth\RegisterController@register') }}" class="btn btn-outline-teal">
                สมัครสมาชิก
            </a>
        </div>
    </div>

    @yield('content')

    <script src="{{ assetV('assets/js/jquery.min.js') }}"></script>
    <script src="{{ assetV('assets/js/bootstrap.min.js') }}"></script>
    @yield('script')
</body>
</html>
