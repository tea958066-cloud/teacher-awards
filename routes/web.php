<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VotingController;
use Illuminate\Support\Facades\Route;

// Voting routes
Route::get('/', [VotingController::class, 'welcome'])->name('welcome');
Route::get('/vote/select', [VotingController::class, 'selectTeacher'])->name('vote.select');
Route::post('/vote/select', [VotingController::class, 'processSelect'])->name('vote.select.post');
Route::get('/vote/rules', [VotingController::class, 'rules'])->name('vote.rules');
Route::post('/vote/rules', [VotingController::class, 'agreeRules'])->name('vote.rules.post');
Route::get('/vote/cast', [VotingController::class, 'castVote'])->name('vote.cast');
Route::post('/vote/submit', [VotingController::class, 'submitVote'])->name('vote.submit');
Route::get('/vote/thankyou', [VotingController::class, 'thankyou'])->name('vote.thankyou');

// Admin auth routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin panel routes (protected)
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/results', [AdminController::class, 'results'])->name('results');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('teachers');
    Route::post('/teachers/add', [AdminController::class, 'addTeacher'])->name('teachers.add');
    Route::post('/teachers/{teacher}/update', [AdminController::class, 'updateTeacher'])->name('teachers.update');
    Route::post('/teachers/{teacher}/toggle', [AdminController::class, 'toggleTeacher'])->name('teachers.toggle');
    Route::delete('/teachers/{teacher}', [AdminController::class, 'deleteTeacher'])->name('teachers.delete');
    Route::post('/voting/open', [AdminController::class, 'openVoting'])->name('voting.open');
    Route::post('/voting/close', [AdminController::class, 'closeVoting'])->name('voting.close');
    Route::post('/voting/reset', [AdminController::class, 'resetVoting'])->name('voting.reset');
    Route::get('/export/csv', [AdminController::class, 'exportCsv'])->name('export.csv');
    Route::get('/print', [AdminController::class, 'printResults'])->name('print');
});
