<?php

use App\Http\Controllers\LibroController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Principal');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/libros', [LibroController::class, 'index'])->name('libros.list');
Route::post('/libros-delete', [LibroController::class, 'destroy'])->name('libros.destroy');
Route::post('/libros-update', [LibroController::class, 'update'])->name('libros.update');
Route::post('/libros-get', [LibroController::class, 'getLibros'])->name('libros.get');

