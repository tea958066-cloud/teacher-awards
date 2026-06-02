@extends('layouts.app')

@section('title', 'Cast Your Vote — Teacher Excellence Awards')

@section('styles')
<style>
    .category-card {
        border-radius: 16px; overflow: hidden; margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,.08); border: none;
        transition: transform .2s;
    }
    .category-card:hover { transform: translateY(-2px); }
    .category-header {
        background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
        color: #fff; padding: 18px 24px;
    }
    .category-number {
        width: 36px; height: 36px; background: #ffd700; color: #1a237e;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-weight: 700; flex-shrink: 0;
    }
    .nominee-item {
        display: flex; align-items: center;
        padding: 10px 14px; border-radius: 10px; margin-bottom: 8px;
        border: 2px solid #e8eaf6; cursor: pointer; transition: all .2s;
    }
    .nominee-item:hover { border-color: #3949ab; background: #f0f2ff; }
    .nominee-item input[type=radio]:checked ~ .nominee-label {
        color: #1a237e; font-weight: 600;
    }
    .nominee-item:has(input[type=radio]:checked) {
        border-color: #1a237e; background: #e8eaf6;
    }
    .nominee-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        background: linear-gradient(135deg, #3949ab, #7b1fa2);
        color: #fff; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .9rem; flex-shrink: 0; margin-right: 12px;
    }
    .self-vote-disabled { opacity: .45; cursor: not-allowed !important; }
    .sticky-bar {
        position: sticky; bottom: 0; background: #fff;
        border-top: 1px solid #e0e0e0; z-index: 50;
        padding: 14px 0; box-shadow: 0 -4px 12px rgba(0,0,0,.08);
    }
    .progress-indicator { font-size: .85rem; color: #666; }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9 col-lg-8">

        <div class="progress-steps mb-4">
            <div class="progress-step done"><span class="step-badge" style="background:#4caf50;color:#fff"><i class="bi bi-check-lg"></i></span> Identify</div>
            <div class="progress-divider"><i class="bi bi-chevron-right"></i></div>
            <div class="progress-step done"><span class="step-badge" style="background:#4caf50;color:#fff"><i class="bi bi-check-lg"></i></span> Rules</div>
            <div class="progress-divider"><i class="bi bi-chevron-right"></i></div>
            <div class="progress-step active"><span class="step-badge">3</span> Vote</div>
        </div>

        <div class="alert alert-primary d-flex align-items-center" style="border-radius:12px">
            <i class="bi bi-person-check-fill fs-4 me-3"></i>
            <div>
                Voting as: <strong>{{ $voter->name }}</strong> &mdash;
                <span class="text-muted">Please complete all {{ $categories->count() }} categories</span>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger" style="border-radius:12px">
            @foreach($errors->all() as $error)
            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('vote.submit') }}" id="votingForm">
            @csrf

            @foreach($categories as $index => $category)
            <div class="category-card card">
                <div class="category-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="category-number">{{ $index + 1 }}</div>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $category->name }}</h5>
                            @if($category->description)
                            <small style="opacity:.8">{{ $category->description }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        @foreach($teachers as $teacher)
                        @php $isSelf = ($teacher->id === $voter->id); @endphp
                        <div class="col-md-6">
                            <label class="nominee-item w-100 {{ $isSelf ? 'self-vote-disabled' : '' }}" for="vote_{{ $category->id }}_{{ $teacher->id }}">
                                <input type="radio"
                                    name="votes[{{ $category->id }}]"
                                    id="vote_{{ $category->id }}_{{ $teacher->id }}"
                                    value="{{ $teacher->id }}"
                                    {{ $isSelf ? 'disabled' : '' }}
                                    {{ old("votes.{$category->id}") == $teacher->id ? 'checked' : '' }}
                                    class="me-2 category-radio"
                                    data-category="{{ $category->id }}"
                                    required>
                                <div class="nominee-avatar">{{ substr($teacher->name, 0, 1) }}</div>
                                <span class="nominee-label">
                                    {{ $teacher->name }}
                                    @if($isSelf) <span class="badge bg-secondary ms-1">You</span> @endif
                                </span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

            <div class="sticky-bar">
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="progress-indicator">
                            <span id="votedCount">0</span> of {{ $categories->count() }} categories completed
                        </div>
                        <button type="button" class="btn btn-primary btn-lg px-5" style="border-radius:10px" id="submitBtn" disabled data-bs-toggle="modal" data-bs-target="#confirmModal">
                            <i class="bi bi-send-fill me-2"></i>Submit My Votes
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;overflow:hidden">
            <div class="modal-header" style="background:linear-gradient(90deg,#1a237e,#3949ab)">
                <h5 class="modal-title text-white"><i class="bi bi-send-fill me-2"></i>Confirm Submission</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="fs-1 text-warning mb-3"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <h5>Are you sure you want to submit your votes?</h5>
                <p class="text-muted">Once submitted, your votes <strong>cannot be changed</strong>. Please make sure you are happy with your selections before confirming.</p>
            </div>
            <div class="modal-footer justify-content-center gap-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-success px-5" id="confirmSubmitBtn">
                    <i class="bi bi-check-circle-fill me-1"></i>Confirm Submission
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const totalCategories = {{ $categories->count() }};
const categoryRadios = document.querySelectorAll('.category-radio');
const submitBtn = document.getElementById('submitBtn');
const votedCountEl = document.getElementById('votedCount');

function updateProgress() {
    const voted = new Set();
    categoryRadios.forEach(r => { if (r.checked) voted.add(r.dataset.category); });
    votedCountEl.textContent = voted.size;
    submitBtn.disabled = voted.size < totalCategories;
    submitBtn.classList.toggle('btn-warning', voted.size === totalCategories);
    submitBtn.classList.toggle('btn-primary', voted.size < totalCategories);
}

categoryRadios.forEach(r => r.addEventListener('change', updateProgress));

document.getElementById('confirmSubmitBtn').addEventListener('click', () => {
    document.getElementById('votingForm').submit();
});

updateProgress();
</script>
@endsection
