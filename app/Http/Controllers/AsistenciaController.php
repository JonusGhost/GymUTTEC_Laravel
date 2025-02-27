<?php

namespace App\Http\Controllers;

use App\Models\Asistencias;
use App\Models\Estudiante;
use App\Models\Talleres;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        $asistencias = Asistencias::get();
        return $asistencias;
    }

    public function mostrarLista($taller_id)
    {
        $taller = Talleres::findOrFail($taller_id);
        $alumnos = Estudiante::whereIn('matricula', function($query) use ($taller_id) {
            $query->select('matricula')->from('inscripciones')->where('taller_id', $taller_id);
        })->get();

        return $alumnos;
    }

    public function pasarLista(Request $req)
    {
        if (!isset($req->asistencia) || empty($req->asistencia)) {
            return 'No se enviaron datos de asistencia.';
        }

        $taller = Talleres::find($req->taller_id);
        if (!$taller) {
            return 'Taller no encontrado.';
        }

        $matriculasEnTaller = Estudiante::whereIn('matricula', array_keys($req->asistencia))->whereIn('matricula', function($query) use ($req) {$query->select('matricula')->from('inscripciones')->where('taller_id', $req->taller_id);})->pluck('matricula')->toArray();

        $matriculasInvalidas = array_diff(array_keys($req->asistencia), $matriculasEnTaller);
        if (count($matriculasInvalidas) > 0) {
            return response()->json(['error' => 'Las siguientes matrículas no están inscritas en este taller: ' . implode(', ', $matriculasInvalidas)], 400);
        }

        foreach ($req->asistencia as $matricula => $estado) {
            Asistencias::create([
                'fecha_asistencia' => now(),
                'horas_asignadas' => $req->horas_asignadas ?? 0,
                'taller_id' => $req->taller_id,
                'matricula' => $matricula,
                'estado' => $estado
            ]);
        }

        return 'Ok';
    }
}
