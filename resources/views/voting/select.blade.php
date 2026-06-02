@extends('layouts.app')

@section('title', 'Select Your Name — Teacher Excellence Awards')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">

        <div class="progress-steps mb-4">
            <div class="progress-step active"><span class="step-badge">1</span> Identify</div>
            <div class="progress-divider"><i class="bi bi-chevron-right"></i></div>
            <div class="progress-step"><span class="step-badge" style="background:#e0e0e0;color:#999">2</span> Rules</div>
            <div class="progress-divider"><i class="bi bi-chevron-right"></i></div>
            <div class="progress-step"><span class="step-badge" style="background:#e0e0e0;color:#999">3</span> Vote</div>
        </div>

        <div class="card">
            <div class="card-header py-3" style="background:linear-gradient(90deg,#1a237e,#3949ab);">
                <h4 class="mb-0 text-white"><i class="bi bi-person-circle me-2"></i>Select Your Name</h4>
            </div>
            <div class="card-body p-4">
                <p class="text-muted mb-4">Please select your name from the list below to begin voting. This helps us ensure each teacher votes only once.</p>

                @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('vote.select.post') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="teacher_id" class="form-label fw-semibold">Your Name</label>
                        <select name="teacher_id" id="teacher_id" class="form-select form-select-lg @error('teacher_id') is-invalid @enderror" required>
                            <option value="">— Select your name —</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                    @if($teacher->has_voted) (Already Voted) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info" style="border-radius:10px">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <strong>Note:</strong> If your name shows "Already Voted", you have already completed your voting. Each teacher may vote only once.
                    </div>

                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary btn-lg" style="border-radius:10px">
                            <i class="bi bi-arrow-right-circle-fill me-2"></i>Continue to Voting Rules
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('welcome') }}" class="text-muted text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i>Back to Welcome
            </a>
        </div>
    </div>
</div>
@endsection
