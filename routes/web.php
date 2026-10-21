<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KredsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'kortet']);
Route::get('/kortet', [HomeController::class, 'kortet'])->name('kortet');
Route::get('/kortet/{kreds}', [HomeController::class, 'kreds'])->name('kortet.kreds');
Route::get('/kreds/{key}', [KredsController::class, 'edit'])->name('kreds.edit');
Route::put('/kreds/{key}', [KredsController::class, 'update'])->name('kreds.update');
Route::get('/aktiviteter/{aktivitet?}', [HomeController::class, 'aktiviteter'])->name('aktiviteter');

// The old Nova admin lived at /nova.
Route::redirect('/nova/{any?}', '/admin')->where('any', '.*');

Route::get('/{page}', [HomeController::class, 'page'])->name('page')
    ->where('page', '(?!(admin|livewire|filament|storage|up)(/|$)).*');
