<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DatasetController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');
Route::view('/terms', 'pages.terms')->name('terms');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DatasetController::class, 'index'])->name('dashboard');

    Route::get('/datasets/create', [DatasetController::class, 'create'])->name('datasets.create');
    Route::post('/datasets', [DatasetController::class, 'store'])->name('datasets.store');
    Route::get('/datasets/{dataset}', [DatasetController::class, 'show'])->name('datasets.show');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/datasets/file/{id}/download', [DatasetController::class, 'downloadFile'])->name('datasets.download.file');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
