<?php

use App\Http\Controllers\Auth\GitHubController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/kanban', [KanbanController::class, 'index']);
    Route::post('/kanban/tasks/move', [\App\Http\Controllers\KanbanTaskController::class, 'move']);
});

Route::get('/auth/github', [GitHubController::class, 'redirect']);
Route::get('/auth/github/callback', [GitHubController::class, 'callback']);
Route::get('/github', [GitHubController::class, 'index']);

require __DIR__ . '/auth.php';
