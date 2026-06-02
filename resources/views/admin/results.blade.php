@extends('layouts.admin')

@section('title', 'Results')
@section('page-title', 'Voting Results')

@section('styles')
<style>
    .winner-row { background: linear-gradient(90deg,#fff8e1,#fffde7); }
    .winner-badge { background:#ffd700;color:#1a237e;font-weight:700;font-size:.75rem; }
    .rank-badge { width:28px;height:28px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem; }
    .rank-1 { background:#ffd700;color:#1a237e; }
    .rank-2 { background:#e0e0e0;color:#424242; }
    .rank-3 { background:#ffe0b2;color:#e65100; }
    .rank-other { background:#f5f5f5;color:#757575; }
    .vote-bar { height:8px;border-radius:4px;background:#e8eaf6; }
    .vote-bar-fill { height:100%;border-radius:4px;background:linear-gradient(90deg,#1a237e,#3949ab); }
    .category-title-bar { background:linear-gradient(135deg,#1a237e,#283593);color:#fff;border-radius:12px 12px 0 0;padding:18px 24px; }
    .no-votes { color:#bbb;text-align:center;padding:24px; }
</style>
@endsection

@section('content')

@foreach($categoryResults as $result)
<div class="card mb-4">
    <div class="category-title-bar d-flex align-items-center justify-content-between">
        <div>
            <h5 class="mb-0 fw-bold"><i class="bi bi-trophy-fill me-2" style="color:#ffd700"></i>{{ $result['category']->name }}</h5>
            @if($result['category']->description)
            <small style="opacity:.75">{{ $result['category']->description }}</small>
            @endif
        </div>
        <span class="badge bg-light text-dark">{{ $result['results']->sum('votes') }} votes</span>
    </div>
    <div class="card-body p-0">
        @if($result['results']->isEmpty())
        <div class="no-votes"><i class="bi bi-inbox fs-3 d-block mb-2"></i>No votes recorded yet</div>
        @else
        @php $totalVotes = $result['results']->sum('votes'); @endphp
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:50px" class="ps-4">Rank</th>
                        <th>Teacher</th>
                        <th style="width:100px" class="text-center">Votes</th>
                        <th style="width:200px">Share</th>
                        <th style="width:80px" class="text-center">%</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result['results'] as $index => $row)
                    @php
                        $rank = $index + 1;
                        $pct = $totalVotes > 0 ? round(($row['votes'] / $totalVotes) * 100, 1) : 0;
                        $rankClass = $rank === 1 ? 'rank-1' : ($rank === 2 ? 'rank-2' : ($rank === 3 ? 'rank-3' : 'rank-other'));
                    @endphp
                    <tr class="{{ $rank === 1 ? 'winner-row' : '' }}">
                        <td class="ps-4">
                            <span class="rank-badge {{ $rankClass }}">{{ $rank }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#3949ab,#7b1fa2);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0">
                                    {{ substr($row['teacher']->name ?? '?', 0, 1) }}
                                </div>
                                <span class="fw-semibold">{{ $row['teacher']->name ?? 'Unknown' }}</span>
                                @if($rank === 1 && $row['votes'] > 0)
                                <span class="badge winner-badge ms-1"><i class="bi bi-star-fill me-1"></i>Winner</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <strong>{{ $row['votes'] }}</strong>
                        </td>
                        <td>
                            <div class="vote-bar">
                                <div class="vote-bar-fill" style="width:{{ $pct }}%"></div>
                            </div>
                        </td>
                        <td class="text-center text-muted small">{{ $pct }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endforeach

<div class="text-end">
    <a href="{{ route('admin.export.csv') }}" class="btn btn-success me-2">
        <i class="bi bi-download me-1"></i>Export CSV
    </a>
    <a href="{{ route('admin.print') }}" target="_blank" class="btn btn-outline-dark">
        <i class="bi bi-printer me-1"></i>Print Results
    </a>
</div>
@endsection
