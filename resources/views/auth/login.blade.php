@extends('layouts.login')
@section('content')
    <div class="top-logo">
        <img src="{{ assetV('assets/image/logo.png') }}" alt="URL_SHORT" style="height:40px;">
    </div>

    <div style="width:100%;max-width:360px;">

        <h1>เข้าสู่ระบบ</h1>
        <p class="subtitle">กรุณากรอกข้อมูลเพื่อเข้าใช้งานระบบ</p>

        @if ($errors->any())
            <div class="alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ actionURL('Auth\LoginController@login') }}" method="POST" autocomplete="off"
            class="needs-validation">
            @csrf
            <input type="hidden" name="goto" value="">

            <div class="mb-field">
                <label class="form-label-sm">อีเมล</label>
                <div class="input-group-custom">
                    <div class="ig-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                        placeholder="กรอกอีเมล" class="validate[required]">
                </div>
            </div>

            <div class="mb-field">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label-sm mb-0">รหัสผ่าน</label>
                    <a href="#" class="forgot-link">ลืมรหัสผ่าน?</a>
                </div>
                <div class="input-group-custom">
                    <div class="ig-icon">
                        <i class="bi bi-lock"></i>
                    </div>
                    <input type="password" name="password" id="password" placeholder="กรอกรหัสผ่าน"
                        class="validate[required]">
                    <button type="button" class="ig-action" onclick="togglePassword()" id="toggle-pw-btn">
                        <i class="bi bi-eye-slash" id="eye-icon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                เข้าสู่ระบบ
            </button>
            <a href="{{ actionURL('Auth\RegisterController@register') }}" class="forgot-link">สมัครสมาชิก</a>
        </form>
    </div>
@endsection
@section('script')
    <script>
        function togglePassword() {
            var input = document.getElementById('password');
            var icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye-slash';
            }
        }
    </script>
@endsection
