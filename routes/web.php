<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AfspraakController;
use App\Http\Controllers\BehandelingController;
use App\Http\Controllers\MedewerkerController;
use App\Http\Controllers\ProductController;

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

Route::get('/behandelingen', [BehandelingController::class, 'index'])->name('behandelingen.index');
Route::get('/behandelingen/{id}/producten', [BehandelingController::class, 'producten'])->name('behandelingen.producten');
Route::get('/behandelingen/{behandelingId}/producten/{productId}', [BehandelingController::class, 'productDetail'])->name('behandelingen.producten.show');
Route::get('/behandelingen/{behandelingId}/producten/{productId}/wijzigen', [BehandelingController::class, 'productEdit'])->name('behandelingen.producten.edit');
Route::put('/behandelingen/{behandelingId}/producten/{productId}', [BehandelingController::class, 'productUpdate'])->name('behandelingen.producten.update');

Route::get('/medewerkers', [MedewerkerController::class, 'index'])->name('medewerkers.index');
Route::get('/medewerkers/{id}', [MedewerkerController::class, 'detail'])->name('medewerkers.show');
Route::get('/medewerkers/{id}/wijzigen', [MedewerkerController::class, 'edit'])->name('medewerkers.edit');
Route::put('/medewerkers/{id}', [MedewerkerController::class, 'update'])->name('medewerkers.update');

Route::get('/producten', [ProductController::class, 'index'])->name('producten.index');
Route::get('/producten/{id}', [ProductController::class, 'show'])->name('producten.show');
Route::get('/producten/{id}/wijzigen', [ProductController::class, 'edit'])->name('producten.edit');
Route::put('/producten/{id}', [ProductController::class, 'update'])->name('producten.update');





require __DIR__.'/settings.php';
