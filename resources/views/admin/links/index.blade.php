@extends('layouts.iframe')
@section('content')
   <div class="page-content">
        <div class="page-header">
            <div>
                <h1 class="page-title">Links</h1>
            </div>
            <div class="ms-auto d-flex gap-2">

            </div>
        </div>

        @forelse ($dataLists as $item)
        <div class="table-card p-3 mb-2">
            <div class="row align-items-center g-3">

                <div class="col-12 col-md-7">
                    <div class="d-flex align-items-start gap-3">
                        <div class="form-check pt-2">
                            <input class="form-check-input" type="checkbox" value="">
                        </div>

                        <div class="brand-avatar flex-shrink-0">
                            <i class="bi bi-terminal-toggle"></i>
                        </div>

                        <div class="flex-grow-1 min-w-0">
                            <h5 class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">{{ $item->title??$item->url_real }}</h5>

                            <div class="d-flex align-items-center gap-1 mb-1">
                                <a href="{{ config('app.url') }}{{ $item->url_short }}" target="_blank" class="short-link-text">/{{ $item->url_short }}</a>
                                <button class="btn-copy-link" title="คัดลอกลิงก์"><i class="bi bi-copy"></i></button>
                            </div>

                            <div class="dest-link-wrapper mb-3">
                                <i class="bi bi-arrow-return-right text-muted"></i>
                                <a href="{{ $item->url_real }}" target="_blank" class="dest-link-text text-teal">
                                    {{ $item->url_real }}
                                </a>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <span class="meta-badge"><i class="bi bi-calendar3 mx-1"></i> {{ $item->created_at->format('d/m/Y H:i') }}</span>
                                <span class="meta-badge"><i class="bi bi-person mx-1"></i> {{ $item->user ? $item->user->fullname() : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-5">
                    <div class="d-flex flex-column align-items-md-end gap-3">

                        <div class="d-flex gap-1">
                            <a class="btn-more" title="ดูสถิติเชิงลึก" href="{{ actionURL('AnalyticsController@view', $item->getIdCode()) }}">
                                <i class="bi bi-bar-chart-line"></i>
                            </a>
                            <a class="btn-more modal-show" title="QR Code" href="{{ actionURL('LinksController@qrcode', $item->getIdCode()) }}">
                                <i class="bi bi-qr-code"></i>
                            </a>
                            <div class="dropdown">
                                <button class="btn-more" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots" style="font-size:13px;"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item modal-show"
                                            href="{{ actionURL('Admin\LinksController@edit', $item->getIdCode()) }}">
                                            <img src="{{ assetV('assets/image/icons/edit.png') }}" width="16"
                                                alt=""> แก้ไข
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item modal-show"
                                            href="{{ actionURL('System\LogEditorController@view', [Crypt::encryptString($item->getTable()), $item->getIdCode()]) }}">
                                            <i class="bi bi-info" style="font-size:13px;"></i> Log
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <button type="button"
                                            class="dropdown-item btn btn-outline-lightgrey btn-h-light-danger btn-a-light-danger w-100"
                                            {{ modalBoxVal(actionURL('Admin\LinksController@cancel', $item->getIdCode()), null, 'ยืนยันการยกเลิก', 'ยกเลิก') }} >
                                            <img id="eye-icon"
                                                    src="{{ assetV('assets/image/icons/trash.png') }}"
                                                    class="" width="16" alt=""> ลบทิ้ง
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="d-flex gap-2 w-100 justify-content-md-end">
                            <div class="stat-box">
                                <div class="stat-number">{{ number_format($item->number_view ?? 0, 0, '.', ',') }}</div>
                                <div class="stat-label">view</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-number">{{ number_format($item->number_review ?? 0, 0, '.', ',') }}</div>
                                <div class="stat-label">review</div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        @empty
        <div role="alert"
            class="alert alert-warning bgc-warning-l4 brc-warning-m3 border-2 d-flex align-items-center mb-0 py-5">
            <i class="fas fa-exclamation-circle mr-3 fa-2x text-orange"></i>
            <div class="text-dark-tp2 text-center">
                No links found.
            </div>
        </div>
        @endforelse
    </div>
@endsection
@section('script')
<script>
    $(function() {
        $('.btn-copy-link').on('click', function() {
            // var shortLink = $(this).siblings('.short-link-text').text();
            var shortLink = $(this).siblings('.short-link-text').attr("href");
            navigator.clipboard.writeText(shortLink).then(function() {
                // alert('Short link copied to clipboard: ' + shortLink);
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        });
    });
</script>
@endsection
