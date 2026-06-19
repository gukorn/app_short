@extends('layouts.iframe')
@section('content')
    <div class="page-content">
        <div class="page-header">
            <div>
                <h1 class="page-title">Analytics</h1>
            </div>
            <div class="ms-auto d-flex gap-2">
                {{ $data->title??$data->url_real }}
            </div>
        </div>
    <div class="table-card p-3 mb-2">
        <div style="position: relative; height:300px;">
            <canvas id="linkTrafficChart"></canvas>
        </div>
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
