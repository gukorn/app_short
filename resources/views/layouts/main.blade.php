<!doctype html>
<html lang="en" style="font-size: 1.025rem;">

<head>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <title>{{ config('app.name') }} - @yield('title', '')</title>
    <link rel="stylesheet" type="text/css" href="{{ assetV('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetV('assets/css/bootstrap-icons.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ assetV('assets/components/select2/select2.min.css') }}">
    <link rel="stylesheet" media="screen, print"
        href="{{ assetV('assets/components/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ assetV('assets/components/validationEngine/jquery.validationEngine.min.css') }}"
        type="text/css" />


    <link rel="stylesheet" type="text/css" href="{{ assetV('assets/css/app.bundle.css') }}">
    <link rel="icon" type="image/png" href="{{ assetV('assets/favicon.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ assetV('assets/js/jquery.min.js') }}"></script>
    <script src="{{ assetV('assets/js/bootstrap.min.js') }}"></script>
</head>

<body data-url="{{ config('app.url') }}" data-dashboard="{{ actionURL('DashboardController@index') }}">
    <nav id="sidebar">
        <div class="sidebar-logo">
            <i class="bi bi-boxes logo-icon"></i>
            {{-- <span class="logo-text">APP<strong>WMS</strong></span> --}}
            {{-- <img src="{{ assetV('assets/image/logo.png') }}" width="120" alt="Logo"> --}}
            <button id="toggle-btn" title="Toggle sidebar" class="ms-auto">
                <i class="bi bi-list"></i>
            </button>
        </div>

        @include('layouts.menu')

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="avatar">U</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->fullname() }}</div>
                </div>
                <a href="{{ actionURL('Auth\LoginController@logout') }}" class="btn-logout btn-more" title="ออกจากระบบ">
                    <i class="bi bi-power ms-auto " style="font-size:14px;"></i>
                </a>
            </div>
        </div>
    </nav>

    <div id="dee-iframe"></div>
    <script src="{{ assetV('assets/components/select2/select2.min.js') }}"></script>
    <script src="{{ assetV('assets/components/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ assetV('assets/components/validationEngine/languages/jquery.validationEngine-th.js') }}"></script>
    <script src="{{ assetV('assets/components/validationEngine/jquery.validationEngine.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ assetV('assets/js/app.bundle.js') }}"></script>
</body>

</html>
