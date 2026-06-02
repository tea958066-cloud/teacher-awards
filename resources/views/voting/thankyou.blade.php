@extends('layouts.app')

@section('title', 'Thank You — Teacher Excellence Awards')

@section('styles')
<style>
    .success-icon { font-size: 5rem; color: #4caf50; animation: pulse 1.5s ease-in-out infinite; }
    @keyframes pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.08)} }
    .confetti-card { background: linear-gradient(135deg,#e8f5e9,#f1f8e9); border-radius:20px; border: 2px solid #a5d6a7; }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card text-center p-5 confetti-card">
            <div class="success-icon mb-3"><i class="bi bi-check-circle-fill"></i></div>
            <h1 class="fw-bold mb-3" style="color:#1b5e20">Thank You for Voting!</h1>
            <p class="fs-5 text-success mb-3">Your votes have been <strong>successfully recorded</strong>.</p>
            <hr>
            <p class="text-muted">Thank you for helping recognize excellence among our teaching staff.</p>
            <p class="text-muted">Your participation contributes to a <strong>fair and meaningful</strong> awards process.</p>

            <div class="row g-3 mt-2 mb-4">
                <div class="col-4">
                    <div class="bg-white rounded-3 p-3 shadow-sm">
                        <div class="fs-3 text-success mb-1"><i class="bi bi-patch-check-fill"></i></div>
                        <div class="small text-muted">Votes Saved</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="bg-white rounded-3 p-3 shadow-sm">
                        <div class="fs-3 text-primary mb-1"><i class="bi bi-shield-fill-check"></i></div>
                        <div class="small text-muted">Confidential</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="bg-white rounded-3 p-3 shadow-sm">
                        <div class="fs-3 text-warning mb-1"><i class="bi bi-trophy-fill"></i></div>
                        <div class="small text-muted">Fair Process</div>
                    </div>
                </div>
            </div>

            <a href="{{ route('welcome') }}" class="btn btn-success btn-lg px-5" style="border-radius:50px">
                <i class="bi bi-house-fill me-2"></i>Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
