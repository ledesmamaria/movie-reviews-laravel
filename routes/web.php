<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ValoracionController;
use App\Models\Pelicula;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $peliculas = Pelicula::with(['generoRelacion', 'valoraciones'])->get();

    return view('principal', [
        'peliculas' => $peliculas,
    ]);
})->name('catalogo');

Route::get('/mis-valoraciones', function () {
    /** @var \App\Models\User $usuario */
    $usuario = Auth::user();

    $valoraciones = $usuario
        ->valoraciones()
        ->with('peliculaRelacion')
        ->latest()
        ->get();

    return view('privada.principal', [
        'recuento' => $valoraciones->count(),
        'valoraciones' => $valoraciones,
    ]);
})->middleware('auth')->name('valoraciones.index');

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login.form');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::any('/peliculas/valorar', [ValoracionController::class, 'create'])
    ->middleware('auth')
    ->name('valoraciones.create');

Route::post('/peliculas/{pelicula}/valoraciones', [ValoracionController::class, 'store'])
    ->middleware('auth')
    ->name('valoraciones.store');

Route::get('/valoraciones/{id}/eliminar', [ValoracionController::class, 'confirmDelete'])
    ->middleware('auth')
    ->name('valoraciones.delete');

Route::post('/valoraciones/{id}/eliminar', [ValoracionController::class, 'destroy'])
    ->middleware('auth')
    ->name('valoraciones.destroy');