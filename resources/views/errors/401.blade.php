@extends('layouts.empty')
@section('content')
    <div id="divErr" class="page-content" style="height: 700px;">
        <div class="h-alt-hf d-flex flex-column align-items-center justify-content-center text-center">
            <h1 class="page-error color-fusion-500">
                <span class="text-gradient">401</span> Unauthorized
                <small class="fw-500">
                    คุณไม่ได้รับอนุญาตเข้าใช้งานส่วนนี้
                </small>
            </h1>
            <h3 class="fw-500 mb-5">
                {{ $exception->getMessage() }}
            </h3>
        </div>
    </div>
@endsection
@section('script')
    <script>
        jQuery(function($) {
            $('#divErr').height(parent.$('body').height() - 200);
        });
    </script>
@endsection
