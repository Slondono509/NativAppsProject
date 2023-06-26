<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EstudianteCursoController;
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
    return view('welcome');
});


Route::resource('estudiante', EstudianteController::class)->name('index','estudiante');
Route::resource('curso', CursoController::class)->name('index','curso');
Route::resource('estudiante-curso', EstudianteCursoController::class);