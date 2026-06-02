@extends('layouts.app')

@section('title', 'Voting Guidelines — Teacher Excellence Awards')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">

        <div class="progress-steps mb-4">
            <div class="progress-step done"><span class="step-badge" style="background:#4caf50;color:#fff"><i class="bi bi-check-lg"></i></span> Identify</div>
            <div class="progress-divider"><i class="bi bi-chevron-right"></i></div>
            <div class="progress-step active"><span class="step-badge">2</span> Rules</div>
            <div class="progress-divider"><i class="bi bi-chevron-right"></i></div>
            <div class="progress-step"><span class="step-badge" style="background:#e0e0e0;color:#999">3</span> Vote</div>
        </div>

        <div class="card">
            <div class="card-header py-3" style="background:linear-gradient(90deg,#1a237e,#3949ab);">
                <h4 class="mb-0 text-white"><i class="bi bi-clipboard-check me-2"></i>Voting Guidelines</h4>
            </div>
            <div class="card-body p-4">
                <p class="text-muted mb-4">Hello <strong>{{ session('voter_name') }}</strong>! Before you begin, please read and agree to the following voting guidelines.</p>

                @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <div class="list-group list-group-flush mb-4">
                    @foreach([
                        ['bi-1-circle-fill','text-primary','You may vote <strong>only once</strong>.'],
                        ['bi-check2-square','text-success','You may select <strong>only one teacher per category</strong>.'],
                        ['bi-person-x-fill','text-danger','You <strong>cannot vote for yourself</strong>.'],
                        ['bi-shield-lock-fill','text-info','All votes are <strong>confidential</strong>.'],
                        ['bi-lock-fill','text-warning','Votes <strong>cannot be changed</strong> after submission.'],
                        ['bi-heart-fill','text-danger','Please vote <strong>fairly and honestly</strong>.'],
                    ] as [$icon, $color, $text])
                    <div class="list-group-item border-0 d-flex align-items-start gap-3 px-0 py-3">
                        <div class="fs-4 {{ $color }} flex-shrink-0"><i class="bi {{ $icon }}"></i></div>
                        <div class="pt-1">{!! $text !!}</div>
                    </div>
                    @endforeach
                </div>

                <form method="POST" action="{{ route('vote.rules.post') }}">
                    @csrf
                    <div class="form-check mb-4 p-3" style="background:#f8f9ff;border-radius:10px;border:2px solid #e8eaf6">
                        <input type="checkbox" class="form-check-input @error('agree') is-invalid @enderror"
                               name="agree" id="agree" value="1" {{ old('agree') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="agree">
                            I have read and understood all the voting guidelines. I agree to vote fairly and responsibly.
                        </label>
                        @error('agree')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" style="border-radius:10px">
                            <i class="bi bi-play-fill me-2"></i>Begin Voting
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
