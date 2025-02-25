<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\GimnasioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TallerController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [LoginController::class,'login']);

Route::post('registro_a', [RegisterController::class,'a_register']);
Route::get('administradores', [AdministradorController::class,'index']);
Route::post('mod_administradores', [AdministradorController::class,'store']);

Route::post('registro_d', [RegisterController::class,'d_register']);
Route::get('docentes', [DocenteController::class,'index']);
Route::post('mod_docentes', [DocenteController::class,'store']);

Route::post('registro_e', [RegisterController::class,'e_register']);
Route::get('estudiantes', [EstudianteController::class,'index']);
Route::post('mod_estudiantes', [EstudianteController::class,'store']);

Route::post('registro_t', [RegisterController::class,'t_register']);
Route::get('talleres', [TallerController::class,'index']);

Route::post('registro_g', [RegisterController::class,'g_register']);
Route::get('gimnasios', [GimnasioController::class,'index']);