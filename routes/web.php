<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DatasetController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DatasetController::class, 'index'])->name('dashboard');

    Route::get('/datasets/create', [DatasetController::class, 'create'])->name('datasets.create');
    Route::post('/datasets', [DatasetController::class, 'store'])->name('datasets.store');
    Route::get('/datasets/{dataset}/download', [DatasetController::class, 'download'])->name('datasets.download');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');

});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
