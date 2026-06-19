@extends('layouts.iframe')
@section('content')
    <div class="page-content">
        <div class="page-header">
            <div>
                <h1 class="page-title">Analytics</h1>
            </div>
            <div class="ms-auto d-flex gap-2">

            </div>
        </div>
    <div class="table-card p-3 mb-2">
        <div style="position: relative; height:300px;">
            <canvas id="linkTrafficChart"></canvas>
        </div>
    </div>
    <div class="table-card p-3 mb-2">
        @forelse ($dataLists as $key=>$item)
        <div class="row align-items-center g-3">
            <div class="col-12 col-md-7">
                <div class="d-flex align-items-start gap-3">
                    <div class="form-check pt-2">
                        {{ $key+1}}
                    </div>

                    <div class="brand-avatar flex-shrink-0">
                        <i class="bi bi-terminal-toggle"></i>
                    </div>

                    <div class="flex-grow-1 min-w-0">
                        <h5 class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">{{ $item->urlshort->title??$item->urlshort->url_real }}</h5>

                        <div class="d-flex align-items-center gap-1 mb-1">
                            <a href="{{ config('app.url') }}{{ $item->urlshort->url_short }}" target="_blank" class="short-link-text">/{{ $item->urlshort->url_short }}</a>
                            <button class="btn-copy-link" title="คัดลอกลิงก์"><i class="bi bi-copy"></i></button>
                        </div>

                        <div class="dest-link-wrapper mb-3">
                            <i class="bi bi-arrow-return-right text-muted"></i>
                            <a href="{{ $item->urlshort->url_real }}" target="_blank" class="dest-link-text text-teal">
                                {{ $item->urlshort->url_real }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-5">
                <div class="d-flex flex-column align-items-md-end gap-3">
                    <div class="d-flex gap-2 w-100 justify-content-md-end">
                            <span class="stat-label"><span class="stat-number">{{ number_format($item->total_view ?? 0, 0, '.', ',') }}</span>view</span>
                            <span class="stat-label"><span class="stat-number">{{ number_format($item->total_review ?? 0, 0, '.', ',') }}</span>review</span>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctxAnalytics = document.getElementById('linkTrafficChart').getContext('2d');
    var chartLabels = @json($dates);
    var dataViews = @json($views);
    var dataReviews = @json($reviews);
    new Chart(ctxAnalytics, {
    type: 'line', // bar
    data: {
        labels: chartLabels,
        datasets: [
            {
                label: 'Views ',
                data: dataViews,
                borderColor: '#398276',
                backgroundColor: 'rgba(57, 130, 118, 0.1)',
                tension: 0.3
            },
            {
                label: 'Reviews',
                data: dataReviews,
                borderColor: '#64748b',
                backgroundColor: 'rgba(100, 116, 139, 0.1)',
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>
@endsection
