<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AfspraakController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/afspraken', [AfspraakController::class, 'index'])->name('afspraken.index');
    Route::get('/afspraken/{id}', [AfspraakController::class, 'show'])->name('afspraken.show');
    Route::get('/afspraken/{id}/wijzigen', [AfspraakController::class, 'edit'])->name('afspraken.edit');
    Route::put('/afspraken/{id}', [AfspraakController::class, 'update'])->name('afspraken.update');
});





require __DIR__.'/settings.php';
