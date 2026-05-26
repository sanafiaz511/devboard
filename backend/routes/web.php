<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\GitHubController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\KanbanTaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/kanban', [KanbanController::class, 'index']);
    Route::post('/kanban/tasks/move', [KanbanTaskController::class, 'move']);
    Route::get('/activities', [ActivityController::class, 'index']);
    Route::get('/github', [GitHubController::class, 'index']);
    Route::post('/user/theme', function (\Illuminate\Http\Request $request) {
        $request->user()->update([
            'dark_mode' => $request->dark_mode
        ]);

        return response()->json(['success' => true]);
    });
});

Route::get('/auth/github', [GitHubController::class, 'redirect']);
Route::get('/auth/github/callback', [GitHubController::class, 'callback']);

require __DIR__ . '/auth.php';
