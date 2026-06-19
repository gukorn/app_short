@extends('layouts.modal')

@section('content')

        <div class="card shadow-sm overflow-hidden">

            <div class="card-header bg-white py-3 border-bottom">
                <h2 class="card-title h6 mb-0  font-medium">
                    QR Code
                </h2>
            </div>

            <div class="card-body p-4 text-center">
                {!! QrCode::size(300)->generate(config('app.url') .$data->url_short); !!}
            </div>
            <div class="d-flex gap-2 px-md-2 py-3 border-top">
                <button type="button" data-bs-dismiss="modal"
                    class="btn btn-light px-4 rounded-3 border text-secondary shadow-sm">
                    ปิด
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
