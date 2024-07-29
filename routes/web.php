<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RuasJalanController;

// Login route
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);

// Logout route
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Register route
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Region Dashboard
Route::get('/region-dashboard', [RegionController::class, 'index'])->name('region.dashboard');

// Ruas Jalan
Route::get('/master', [RuasJalanController::class, 'showRuasJalan'])->name('ruasjalan.master');
Route::get('/map/{encodedPolyline}', [RuasJalanController::class, 'showMap'])->name('map');
Route::get('/ruasjalan/create', [RuasJalanController::class, 'create'])->name('ruasjalan.create');
Route::post('/ruasjalan/store', [RuasJalanController::class, 'store'])->name('ruasjalan.store');
Route::get('/ruasjalan/edit/{id}', [RuasJalanController::class, 'edit'])->name('ruasjalan.edit');
Route::get('/ruasjalan/detail/{id}', [RuasJalanController::class, 'showDetails'])->name('ruasjalan.detail');
Route::delete('/ruasjalan/delete/{id}', [RuasJalanController::class, 'delete'])->name('ruasjalan.delete');
Route::put('/ruasjalan/update/{id}', [RuasJalanController::class, 'update'])->name('ruasjalan.update');
Route::get('/dashboard', [RuasJalanController::class, 'dashboard'])->name('dashboard');

