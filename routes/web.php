<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WarrantController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard/Home redirect
    Route::get('/', function () {
        return redirect()->route('warrants.index');
    });

    // Warrant resource routes
    Route::resource('warrants', WarrantController::class);

    // Additional warrant routes
    Route::get('warrants/{warrant}/report', [WarrantController::class, 'generateReport'])
        ->name('warrants.report');

});

require __DIR__.'/auth.php';
