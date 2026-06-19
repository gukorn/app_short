@extends('layouts.modal')

@section('content')
    @php
        $action = isset($data)
            ? actionURL('Admin\UserController@update', $data->getIdCode())
            : actionURL('Admin\UserController@store');
    @endphp

    <form action="{{ $action }}" class="needs-validation" novalidate formcallback="formcallback"
        @isset($data) data-confirm="ยืนยันแก้ไขข้อมูล ?" data-confirm-confirmbutton="แก้ไขข้อมูล" @endisset>
        @csrf
        @isset($data)
            @method('PUT')
        @endisset

        <div class="card shadow-sm overflow-hidden">

            <div class="card-header bg-white py-3 border-bottom">
                <h2 class="card-title h6 mb-0  font-medium">
                    <i class="bi bi-person-plus me-2"></i>
                    {{ isset($data) ? 'แก้ไขข้อมูลผู้ใช้งาน' : 'เพิ่มข้อมูลผู้ใช้งานใหม่' }}
                </h2>
            </div>

            <input type="hidden" name="location_id" id="location_id" value="{{ isset($data) ? $data->location_id : '' }}">

            <div class="card-body p-4">

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold" for="email">
                            อีเมล์ <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="email" name="email"
                            class="form-control form-control-sm rounded-3 shadow-none border-light-subtle validate[required]"
                            value="{{ isset($data) ? $data->email : '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold" for="password">
                            รหัสผ่าน @empty($data)<span class="text-danger">*</span>@endisset
                        </label>
                        <input type="password" id="password" name="password"
                            class="form-control form-control-sm rounded-3 shadow-none border-light-subtle validate[required]"
                            value="" @empty($data) required @endisset>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold" for="firstname">
                            ชื่อ <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="firstname" name="firstname"
                            class="form-control form-control-sm rounded-3 shadow-none border-light-subtle validate[required]"
                            value="{{ isset($data) ? $data->firstname : '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold" for="lastname">
                            นามสกุล <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="lastname" name="lastname"
                            class="form-control form-control-sm rounded-3 shadow-none border-light-subtle validate[required]"
                            value="{{ isset($data) ? $data->lastname : '' }}" required>
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold" for="firstname">
                            เป็นเจ้าหน้าที่ <span class="text-danger">*</span>
                        </label>
                        <input type="checkbox" id="is_admin" name="is_admin"
                            class="form-control form-control-sm rounded-3 shadow-none border-light-subtle "
                            value="1" {{ isset($data) && $data->is_admin ? 'checked' : '' }}>
                    </div>

                </div>

            </div>
            <div class="d-flex justify-content-end gap-2 px-md-2  py-2 border-top">
                <button type="button" data-bs-dismiss="modal"
                    class="btn btn-light px-4 rounded-3 border text-secondary shadow-sm">
                    ยกเลิก
                </button>
                <button type="submit" class="btn btn-primary px-5 rounded-3 shadow-sm fw-medium">
                    <i class="bi bi-save me-1"></i> บันทึกข้อมูล
                </button>
            </div>

        </div>

    </form>
@endsection
@section('script')
    <script>
        $(function() {
            formcallback = function(data) {
                if (data.message) toastrSuccess(data.message);
                dee_Load(window.location.hash);
                ModalAjax.close();
            }

        });
    </script>
@endsection
