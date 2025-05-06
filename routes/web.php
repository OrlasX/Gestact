<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('plantilla.template');
})->name('template');

// Dashboard, requiere autenticación
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Grupo de rutas que requieren autenticación para perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Redactar, requiere autenticación
Route::get('/redactar', [ActaController::class, 'createRedactar'])
    ->middleware(['auth', 'verified'])
    ->name('redactar');
Route::post('/redactar', [ActaController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('acta.store');

// Mostrar acta, requiere autenticación
Route::get('/show/{id}', [ActaController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('acta.show');
Route::put('/acta/{id}', [ActaController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('acta.update');
    Route::post('/acta/{id}/firmar', [ActaController::class, 'firmar'])
    ->middleware(['auth', 'verified'])
    ->name('acta.firmar');

Route::delete('/acta/{id}', [ActaController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('acta.destroy');

Route::post('/actas/{id}/generar', [ActaController::class, 'generar'])
    ->middleware(['auth', 'verified'])
    ->name('actas.generar');

    Route::get('/actas/{id}/download', [ActaController::class, 'download'])
    ->middleware(['auth', 'verified'])
    ->name('actas.download');



// Rutas de búsqueda, requieren autenticación
Route::get('/buscar', [ActaController::class, 'showBuscarForm'])
    ->middleware(['auth', 'verified'])
    ->name('buscar');
Route::get('/busqueda', [ActaController::class, 'buscar'])
    ->middleware(['auth', 'verified'])
    ->name('busqueda');

// Rutas de usuario protegidas para rol auxiliar
Route::middleware(['auth', 'auxiliar'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
    Route::post('/usuarios/desactivar/{id}', [UserController::class, 'desactivar'])->name('usuarios.desactivar');
    Route::post('/usuarios/activar/{id}', [UserController::class, 'activar'])->name('usuarios.activar');
});




require __DIR__.'/auth.php';
