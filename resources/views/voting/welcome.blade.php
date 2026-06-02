@extends('layouts.app')

@section('title', 'Welcome — Teacher Excellence Awards')

@section('styles')
<style>
    .hero-card {
        background: linear-gradient(135deg, #1a237e 0%, #4a148c 100%);
        color: white; border-radius: 20px;
        box-shadow: 0 8px 32px rgba(26,35,126,.3);
    }
    .award-icon { font-size: 5rem; color: #ffd700; text-shadow: 0 4px 12px rgba(255,215,0,.4); }
    .feature-item { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 16px; }
    .feature-icon {
        width: 44px; height: 44px; border-radius: 12px;
        background: rgba(255,255,255,.15); display: flex;
        align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.3rem;
    }
    .closed-banner { background: linear-gradient(90deg,#b71c1c,#e53935); color:#fff; border-radius:16px; }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="text-center mb-4">
            <div class="award-icon"><i class="bi bi-award-fill"></i></div>
        </div>

        @if(!$votingOpen)
        <div class="closed-banner p-4 mb-4 text-center">
            <i class="bi bi-lock-fill fs-2 d-block mb-2"></i>
            <h4 class="mb-1">Voting is Currently Closed</h4>
            <p class="mb-0">Please check back later or contact the administrator.</p>
        </div>
        @endif

        <div class="hero-card p-4 p-md-5 mb-4">
            <h1 class="text-center mb-3" style="font-size:1.8rem; font-weight:700;">
                Welcome to the<br>
                <span style="color:#ffd700">Teacher Excellence Awards</span><br>
                Voting System
            </h1>
            <hr style="border-color:rgba(255,255,255,.3)">

            <div class="feature-item">
                <div class="feature-icon"><i class="bi bi-hand-thumbs-up"></i></div>
                <div>We appreciate your participation in recognizing and celebrating outstanding teachers.</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="bi bi-star"></i></div>
                <div>Your votes will help identify teachers who have demonstrated excellence, dedication, creativity, punctuality, organization, and a willingness to learn.</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                <div>Voting is <strong>confidential and fair</strong>. Your selections are private and secure.</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="bi bi-clock"></i></div>
                <div>Please take a few minutes to vote honestly and responsibly. The process takes less than 2 minutes.</div>
            </div>

            @if($votingOpen)
            <div class="text-center mt-4">
                <a href="{{ route('vote.select') }}" class="btn btn-warning btn-lg px-5 fw-bold" style="color:#1a237e; border-radius:50px; box-shadow:0 4px 16px rgba(255,215,0,.4)">
                    <i class="bi bi-play-circle-fill me-2"></i>Start Voting
                </a>
            </div>
            @endif
        </div>

        <div class="row g-3">
            <div class="col-4 text-center">
                <div class="card p-3">
                    <div class="fs-2 text-primary mb-1"><i class="bi bi-people-fill"></i></div>
                    <div class="small text-muted">Anonymous</div>
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="card p-3">
                    <div class="fs-2 text-success mb-1"><i class="bi bi-patch-check-fill"></i></div>
                    <div class="small text-muted">Fair & Secure</div>
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="card p-3">
                    <div class="fs-2 text-warning mb-1"><i class="bi bi-trophy-fill"></i></div>
                    <div class="small text-muted">5 Categories</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
