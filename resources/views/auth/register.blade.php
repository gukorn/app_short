@extends('layouts.login')
@section('content')
    <div class="top-logo">
        <img src="{{ assetV('assets/image/logo.png') }}" alt="URL_SHORT" style="height:40px;">
    </div>

    <div style="width:100%;max-width:360px;">

        <h1>สมัครสมาชิก</h1>
        <p class="subtitle">กรุณากรอกข้อมูลเพื่อสร้างบัญชีผู้ใช้</p>

        @if ($errors->any())
            <div class="alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ actionURL('Auth\RegisterController@saveRegister') }}" method="POST" autocomplete="off"
            class="needs-validation">
            @csrf
            <input type="hidden" name="goto" value="{{ url('/') }}/">

            <div class="mb-field">
                <label class="form-label-sm">อีเมล</label>
                <div class="input-group-custom">
                    <div class="ig-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    <input type="text" name="email" id="email" value="{{ old('email') }}"
                        placeholder="กรอกอีเมล" class="validate[required]">
                </div>
            </div>

              <div class="mb-field">
                <label class="form-label-sm">ชื่อผู้ใช้ </label>
                <div class="input-group-custom">
                    <div class="ig-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}"
                        placeholder="กรอกชื่อผู้ใช้" class="validate[required]">
                </div>
            </div>
            <div class="mb-field">
                <label class="form-label-sm">นามสกุล</label>
                <div class="input-group-custom">
                    <div class="ig-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}"
                        placeholder="กรอกนามสกุล" class="validate[required]">
                </div>
            </div>

            <div class="mb-field">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label-sm mb-0">รหัสผ่าน</label>
                </div>
                <div class="input-group-custom">
                    <div class="ig-icon">
                        <i class="bi bi-lock"></i>
                    </div>
                    <input type="password" name="password" id="password" placeholder="กรอกรหัสผ่าน"
                        class="validate[required]">
                    <button type="button" class="ig-action" onclick="togglePassword('password')" id="toggle-pw-btn">
                        <i class="bi bi-eye-slash" id="eye-icon"></i>
                    </button>
                </div>
            </div>
            <div class="mb-field">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label-sm mb-0">ยืนยันรหัสผ่าน</label>
                </div>
                <div class="input-group-custom">
                    <div class="ig-icon">
                        <i class="bi bi-lock"></i>
                    </div>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="ยืนยันรหัสผ่าน"
                        class="validate[required,equals[password]]">
                    <button type="button" class="ig-action" onclick="togglePassword('password_confirmation')" id="toggle-pw-btn">
                        <i class="bi bi-eye-slash" id="eye-icon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                เข้าสู่ระบบ
            </button>

        </form>
    </div>
@endsection
@section('script')
    <script>
        function togglePassword(btn) {
            var input = document.getElementById(btn);
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
