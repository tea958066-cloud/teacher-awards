@extends('layouts.admin')

@section('title', 'Analytics')
@section('page-title', 'Analytics & Charts')

@section('content')

<!-- Participation Pie -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-pie-chart-fill me-2 text-primary"></i>Participation</h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="participationChart" style="max-height:240px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-people-fill me-2 text-info"></i>Participation Summary</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#e8f5e9">
                            <div class="fs-2 fw-bold text-success">{{ $participationData['voted'] }}</div>
                            <div class="text-success small fw-semibold">Teachers Voted</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#fff3e0">
                            <div class="fs-2 fw-bold text-warning">{{ $participationData['not_voted'] }}</div>
                            <div class="text-warning small fw-semibold">Yet to Vote</div>
                        </div>
                    </div>
                    <div class="col-12">
                        @php $total = $participationData['voted'] + $participationData['not_voted']; $pct = $total > 0 ? round(($participationData['voted']/$total)*100,1) : 0; @endphp
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold small">Overall Participation</span>
                            <span class="text-primary fw-bold">{{ $pct }}%</span>
                        </div>
                        <div class="progress" style="height:12px;border-radius:6px">
                            <div class="progress-bar bg-primary" style="width:{{ $pct }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Bar Charts -->
@foreach($chartData as $idx => $data)
<div class="card mb-4">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex align-items-center justify-content-between">
        <h6 class="fw-bold mb-0"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>{{ $data['category'] }}</h6>
        <span class="badge bg-light text-dark">{{ array_sum($data['data']) }} total votes</span>
    </div>
    <div class="card-body">
        @if(empty($data['data']))
        <p class="text-muted text-center py-3">No votes yet for this category</p>
        @else
        <canvas id="chart_{{ $idx }}" style="max-height:280px"></canvas>
        @endif
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<script>
// Participation Pie
new Chart(document.getElementById('participationChart'), {
    type: 'doughnut',
    data: {
        labels: ['Voted', 'Not Voted'],
        datasets: [{
            data: [{{ $participationData['voted'] }}, {{ $participationData['not_voted'] }}],
            backgroundColor: ['#4caf50', '#ffb300'],
            borderWidth: 2
        }]
    },
    options: { plugins: { legend: { position: 'bottom' } }, cutout: '65%' }
});

// Category bar charts
const chartData = @json($chartData);
chartData.forEach((d, i) => {
    const el = document.getElementById('chart_' + i);
    if (!el || d.data.length === 0) return;
    const total = d.data.reduce((a, b) => a + b, 0);
    new Chart(el, {
        type: 'bar',
        data: {
            labels: d.labels,
            datasets: [{
                label: 'Votes',
                data: d.data,
                backgroundColor: d.data.map((v, idx) => idx === 0 ? '#ffd700' : '#3949ab'),
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.raw} votes (${total > 0 ? Math.round(ctx.raw/total*100) : 0}%)`
                    }
                }
            },
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
});
</script>
@endsection
