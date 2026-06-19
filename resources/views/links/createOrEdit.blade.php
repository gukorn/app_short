@extends('layouts.modal')

@section('content')
    @php
        $action = isset($data)
            ? actionURL('LinksController@update', $data->getIdCode())
            : actionURL('LinksController@store');
    @endphp

    <form action="{{ $action }}" class="needs-validation" novalidate formcallback="formcallback"
        @isset($data)data-confirm="ยืนยันแก้ไขข้อมูล ?" data-confirm-confirmbutton="แก้ไขข้อมูล" @endisset>
        @csrf
        @isset($data)
            @method('PUT')
        @endisset

        <div class="card shadow-sm overflow-hidden">

            <div class="card-header bg-white py-3 border-bottom">
                <h2 class="card-title h6 mb-0  font-medium">
                    {{ isset($data) ? 'Edit' : 'Create' }} a new link
                </h2>
            </div>

            <div class="card-body p-4">

                <div class="form-container">
                    <div class="form-header">
                        <div class="header-text">
                            <span class="title-main">Link details</span>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="form-label">Destination URL<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control-custom validate[required,custom[url]]"
                                placeholder="ระบุ URL" id="url_real" name="url_real"  maxlength="200"
                                value="{{ isset($data) ? $data->url_real : '' }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Short link (optional)</label>
                            <input type="text" class="form-control-custom validate[custom[onlyLetterNumber]] text-input"
                                placeholder="ex.: name-link " id="url_short" name="url_short" maxlength="100"
                                value="{{ isset($data) ? $data->url_short : '' }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Title (optional)</label>
                            <input type="text" class="form-control-custom" placeholder="ระบุหัวข้อ" id="title"  maxlength="200"
                                name="title" value="{{ isset($data) ? $data->title : '' }}">
                        </div>
                    </div>
                </div>


            </div>
            <div class="d-flex gap-2 px-md-2 py-3 border-top">
                <button type="button" data-bs-dismiss="modal"
                    class="btn btn-light px-4 rounded-3 border text-secondary shadow-sm">
                    ยกเลิก
                </button>
                <button type="submit" class="btn btn-primary px-3 rounded-3 shadow-sm fw-medium ms-auto">
                    <i class="bi bi-check me-1 h4"></i> บันทึกข้อมูล
                </button>
            </div>

        </div>

    </form>
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
