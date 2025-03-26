<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Models\Reserva;
use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return view('welcome');
});

// Route to redirect to Google's OAuth page
Route::get('/api/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');

// Route to handle the callback from Google
Route::get('/api/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

Route::get('/index', [ReservaController::class, 'index'])->middleware('auth')->name('reservas.index');
Route::get('/reservar', [ReservaController::class, 'create'])->middleware('auth')->name('reservas.create');
Route::post('/index', [ReservaController::class, 'store'])->middleware('auth')->name('reservas.store');
Route::get('/', [ReservaController::class, 'cerrarSesion'])->name('reservas.cerrarSesion');
Route::delete('/index/{id}', [ReservaController::class, 'destroy'])->name('reservas.destroy'); 
