<?php

use App\Http\Controllers\AltaPasajeroController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AltaPasajeroController::class, "empresasDisponibles"]);

Route::match(['get', 'post'],'/altaPasajero', [AltaPasajeroController::class, "altaPasajero"])->name('altaPasajero');

Route::post('/guardar', [AltaPasajeroController::class, "guardar"])->name('guardar');
