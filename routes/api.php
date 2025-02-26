<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\GimnasioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TallerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [LoginController::class,'login']);

Route::get('administradores', [AdministradorController::class,'index']);
Route::post('administrador/guardar', [AdministradorController::class,'store']);
Route::delete('administrador/eliminar/{matricula}', [AdministradorController::class,'destroy']);
Route::get('administrador/{matricula}', [AdministradorController::class,'admin']);

Route::get('docentes', [DocenteController::class,'index']);
Route::post('docente/guardar', [DocenteController::class,'store']);
Route::delete('docente/eliminar/{matricula}', [DocenteController::class,'destroy']);
Route::get('docente/{matricula}', [DocenteController::class,'docent']);

Route::get('estudiantes', [EstudianteController::class,'index']);
Route::post('estudiante/guardar', [EstudianteController::class,'store']);
Route::delete('estudiante/eliminar/{matricula}', [EstudianteController::class,'destroy']);
Route::get('estudiante/{matricula}', [EstudianteController::class,'estudent']);

Route::get('talleres', [TallerController::class,'index']);
Route::post('taller/guardar', [TallerController::class,'store']);

Route::get('gimnasios', [GimnasioController::class,'index']);
Route::post('gimnasio/guardar', [GimnasioController::class,'store']);