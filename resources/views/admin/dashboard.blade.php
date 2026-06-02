@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('styles')
<style>
    .stat-card .card-body { padding: 24px; }
    .stat-icon { width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.6rem; }
    .progress { height: 8px; border-radius: 4px; }
    .pending-badge { background: #fff3e0; color: #e65100; border-radius: 8px; padding: 4px 10px; font-size:.8rem; }
    .voting-status-open { background: linear-gradient(135deg,#1b5e20,#2e7d32); }
    .voting-status-closed { background: linear-gradient(135deg,#b71c1c,#c62828); }
</style>
@endsection

@section('content')

<!-- Voting Status Banner -->
<div class="card mb-4 {{ $votingOpen ? 'voting-status-open' : 'voting-status-closed' }} text-white">
    <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="fs-2"><i class="bi bi-{{ $votingOpen ? 'unlock-fill' : 'lock-fill' }}"></i></div>
            <div>
                <h5 class="mb-0">Voting is Currently <strong>{{ $votingOpen ? 'OPEN' : 'CLOSED' }}</strong></h5>
                <small style="opacity:.8">{{ $votingOpen ? 'Teachers can submit their votes.' : 'No new votes are being accepted.' }}</small>
            </div>
        </div>
        <div class="d-flex gap-2">
            @if($votingOpen)
            <form method="POST" action="{{ route('admin.voting.close') }}">
                @csrf
                <button class="btn btn-light fw-semibold"><i class="bi bi-lock-fill me-1"></i>Close Voting</button>
            </form>
            @else
            <form method="POST" action="{{ route('admin.voting.open') }}">
                @csrf
                <button class="btn btn-light fw-semibold"><i class="bi bi-unlock-fill me-1"></i>Open Voting</button>
            </form>
            @endif
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon" style="background:#e8eaf6;color:#1a237e"><i class="bi bi-people-fill"></i></div>
                    <span class="badge bg-primary">Total</span>
                </div>
                <h3 class="fw-bold mb-1">{{ $totalTeachers }}</h3>
                <div class="text-muted small">Total Teachers</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon" style="background:#e8f5e9;color:#2e7d32"><i class="bi bi-check-circle-fill"></i></div>
                    <span class="badge bg-success">Voted</span>
                </div>
                <h3 class="fw-bold mb-1">{{ $votedTeachers }}</h3>
                <div class="text-muted small">Votes Submitted</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon" style="background:#fff8e1;color:#f57f17"><i class="bi bi-hourglass-split"></i></div>
                    <span class="badge bg-warning text-dark">Pending</span>
                </div>
                <h3 class="fw-bold mb-1">{{ $notVotedTeachers }}</h3>
                <div class="text-muted small">Yet to Vote</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon" style="background:#fce4ec;color:#c62828"><i class="bi bi-percent"></i></div>
                    <span class="badge bg-danger">Rate</span>
                </div>
                <h3 class="fw-bold mb-1">{{ $participationPct }}%</h3>
                <div class="text-muted small">Participation</div>
            </div>
        </div>
    </div>
</div>

<!-- Participation Progress -->
<div class="card mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between mb-2">
            <span class="fw-semibold">Participation Progress</span>
            <span class="text-muted small">{{ $votedTeachers }} / {{ $totalTeachers }} teachers</span>
        </div>
        <div class="progress mb-2">
            <div class="progress-bar bg-success" style="width:{{ $participationPct }}%"></div>
        </div>
        <div class="d-flex justify-content-between">
            <small class="text-success"><i class="bi bi-check-circle me-1"></i>{{ $votedTeachers }} Voted</small>
            <small class="text-warning"><i class="bi bi-clock me-1"></i>{{ $notVotedTeachers }} Pending</small>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Pending Teachers -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-hourglass-split me-2 text-warning"></i>Teachers Yet to Vote</h6>
                <span class="badge bg-warning text-dark">{{ $notVotedTeachers }}</span>
            </div>
            <div class="card-body p-3">
                @if($pendingTeachers->isEmpty())
                <div class="text-center py-4 text-success">
                    <i class="bi bi-check-circle-fill fs-2 mb-2 d-block"></i>
                    All teachers have voted!
                </div>
                @else
                <div class="list-group list-group-flush">
                    @foreach($pendingTeachers as $teacher)
                    <div class="list-group-item border-0 d-flex align-items-center gap-2 py-2">
                        <div style="width:32px;height:32px;background:#e8eaf6;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;color:#1a237e">
                            {{ substr($teacher->name, 0, 1) }}
                        </div>
                        <span>{{ $teacher->name }}</span>
                        <span class="pending-badge ms-auto">Pending</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Admin Controls -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-gear-fill me-2 text-primary"></i>Admin Controls</h6>
            </div>
            <div class="card-body p-3">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.results') }}" class="btn btn-outline-primary">
                        <i class="bi bi-trophy me-2"></i>View Voting Results
                    </a>
                    <a href="{{ route('admin.analytics') }}" class="btn btn-outline-info">
                        <i class="bi bi-bar-chart me-2"></i>View Analytics
                    </a>
                    <a href="{{ route('admin.teachers') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-people me-2"></i>Manage Teachers
                    </a>
                    <a href="{{ route('admin.export.csv') }}" class="btn btn-outline-success">
                        <i class="bi bi-download me-2"></i>Export Results (CSV)
                    </a>
                    <a href="{{ route('admin.print') }}" target="_blank" class="btn btn-outline-dark">
                        <i class="bi bi-printer me-2"></i>Print Results
                    </a>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#resetModal">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Reset All Votes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reset Modal -->
<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;overflow:hidden">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Reset</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="fs-1 text-danger mb-2"><i class="bi bi-trash3-fill"></i></div>
                <h5>Reset All Votes?</h5>
                <p class="text-muted">This will permanently delete <strong>all votes</strong> and mark all teachers as not having voted. This action <strong>cannot be undone</strong>.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.voting.reset') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4"><i class="bi bi-trash3 me-1"></i>Yes, Reset All</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
