<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\GimnasioController;
use App\Http\Controllers\InscripionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TallerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Login
Route::post('login', [LoginController::class,'login']);

// Administradores
Route::get('administradores', [AdministradorController::class,'index']);
Route::post('administrador/guardar', [AdministradorController::class,'store']);
Route::delete('administrador/eliminar/{matricula}', [AdministradorController::class,'destroy']);
Route::get('administrador/{matricula}', [AdministradorController::class,'admin']);
    
Route::post('administrador/talleres/asignar-docente/{matricula}/{taller_id}', [AdministradorController::class,'altaT']);
Route::post('administrador/talleres/baja-docente', [AdministradorController::class,'bajaT']);       // <-- Se envia JSON
/*
{
    "taller_id": 1,
    "docente_id": "1001"
}
*/
Route::post('administrador/gimnasio/asignar-docente', [AdministradorController::class,'altaG']);    // <-- Se envia JSON
/*
{
    "gimnasio_id": 1,
    "docente_ids": ["1001", "1002", "1003"]
}
*/
Route::post('administrador/gimnasio/baja-docente', [AdministradorController::class,'bajag']);       // <-- Se envia JSON
/*
{
    "gimnasio_id": 1,
    "docente_id": "1001"
}
*/

// Docentes
Route::get('docentes', [DocenteController::class,'index']);
Route::post('docente/guardar', [DocenteController::class,'store']);
Route::delete('docente/eliminar/{matricula}', [DocenteController::class,'destroy']);
Route::get('docente/{matricula}', [DocenteController::class,'docent']);

// Estudiantes
Route::get('estudiantes', [EstudianteController::class,'index']);
Route::post('estudiante/guardar', [EstudianteController::class,'store']);
Route::delete('estudiante/eliminar/{matricula}', [EstudianteController::class,'destroy']);
Route::get('estudiante/{matricula}', [EstudianteController::class,'estudent']);
Route::post('estudiante/taller', [EstudianteController::class, 'talleresYGimnasios']);

Route::post('estudiante/inscripcion', [EstudianteController::class,'inscrip']);
Route::post('estudiante/anular', [EstudianteController::class,'anular']);

// Talleres
Route::get('talleres', [TallerController::class,'index']);
Route::post('taller/guardar', [TallerController::class,'store']);
Route::delete('taller/eliminar/{id}', [TallerController::class,'destroy']);
Route::get('taller/{id}', [TallerController::class,'taller']);
Route::get('talleres/horario/{id}', [TallerController::class,'horario']);

// Gimnasios
Route::get('gimnasios', [GimnasioController::class,'index']);
Route::post('gimnasio/guardar', [GimnasioController::class,'store']);
Route::delete('gimnasio/eliminar/{id}', [GimnasioController::class,'destroy']);
Route::get('gimnasio/{id}', [GimnasioController::class,'gimnasio']);

// Asistencias
Route::get('asistencias', [AsistenciaController::class,'index']);

Route::get('asistencias/{taller_id}', [AsistenciaController::class, 'mostrarLista']);
Route::post('asistencias/pasar-lista', [AsistenciaController::class, 'pasarLista']);       // <-- Se envia JSON
/* 
{
    "taller_id": 1,
    "asistencia": {
        "2522160180": "presente",
        "2522160181": "ausente",
        "2522160182": "justificado"
    }
}
*/

// Inscripciones
Route::get('inscripciones', [InscripionController::class,'index']);
Route::get('inscripcion/estudiante/{matricula}', [InscripionController::class,'esttaller']);