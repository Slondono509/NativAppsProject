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

Route::resource('estudiante', EstudianteController::class)->name('index','estudiante');
Route::get('estudiante-reload',  [EstudianteController::class, 'reloadEstudiantes']);
Route::get('/',  [EstudianteController::class, 'index']);

Route::resource('curso', CursoController::class)->name('index','curso');
Route::get('curso-reload',  [CursoController::class, 'reloadCursos']);

Route::resource('estudiante-curso', EstudianteCursoController::class);