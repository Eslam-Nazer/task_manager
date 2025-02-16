<?php

declare(strict_types=1);

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Gemini\GeminiController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('/', '/login');
    Route::get('login')->name('login');
    Route::get('dashboard', [TaskController::class, 'index'])->name('dashboard');
    Route::get('tasks/create', [TaskController::class, 'create'])->name('create-task');
    Route::post('tasks/create', [TaskController::class, 'store'])->name('store-task');
    Route::get('tasks/{id}/edit', [TaskController::class, 'edit'])->name('edit-task');
    Route::post('tasks/{id}/edit', [TaskController::class, 'update'])->name('update-task');
    Route::get('tasks/{id}/delete', [TaskController::class, 'destroy'])->name('delete-task');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/chat/gemini/{id?}', [GeminiController::class, 'index'])->name('gemini');
    Route::post('/chat/gemini', [GeminiController::class, 'store'])->name("gemini-store");
});

// Route::get('/test', function () {
//     return Inertia::render('Dashboard');
// })->name('test');

require __DIR__ . '/auth.php';
