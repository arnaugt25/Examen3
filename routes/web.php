<?php

use App\Http\Controllers\AnunciController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::resource('anunci', AnunciController::class)->middleware('auth');
Route::get('/filter-anuncis', [AnunciController::class, 'filterByCategory'])->name('anuncis.filter');
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
