<?php

namespace App\Http\Controllers;

use App\Models\Asistencias;
use App\Models\Asistencias_gim;
use App\Models\Estudiante;
use App\Models\Gimnasios;
use App\Models\Talleres;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function indextal()
    {
        $asistencias = Asistencias::get();
        return $asistencias;
    }

    public function indexgim()
    {
        $asistencias = Asistencias_gim::get();
        return $asistencias;
    }

    public function mostrarListaTal($taller_id)
    {
        $taller = Talleres::findOrFail($taller_id);
        $alumnos = Estudiante::whereIn('matricula', function($query) use ($taller_id) {
            $query->select('matricula')->from('inscripciones_tal')->where('taller_id', $taller_id);
        })->get();

        return response()->json([
            'taller' => $taller,
            'alumnos' => $alumnos
        ]);
    }

    public function mostrarListaGim($gimnasio_id)
    {
        $gimnasio = Gimnasios::findOrFail($gimnasio_id);
        $alumnos = Estudiante::whereIn('matricula', function($query) use ($gimnasio_id) {
            $query->select('matricula')->from('inscripciones_gim')->where('gimnasio_id', $gimnasio_id);
        })->get();

        return response()->json([
            'taller' => $gimnasio,
            'alumnos' => $alumnos
        ]);
    }

    public function pasarListaTal(Request $req)
    {
        if (!$req->has('asistencia') || empty($req->asistencia)) {
            return response()->json(['error' => 'No se enviaron datos de asistencia.'], 400);
        }

        $taller = Talleres::find($req->taller_id);
        if (!$taller) {
            return response()->json(['error' => 'Taller no encontrado.'], 404);
        }

        $matriculasEnTaller = Estudiante::whereIn('matricula', array_keys($req->asistencia))
            ->whereIn('matricula', function ($query) use ($req) {
                $query->select('matricula')
                    ->from('inscripciones_tal')
                    ->where('taller_id', $req->taller_id);
            })
            ->pluck('matricula')
            ->toArray();

        $matriculasInvalidas = array_diff(array_keys($req->asistencia), $matriculasEnTaller);
        if (!empty($matriculasInvalidas)) {
            return response()->json([
                'error' => 'Las siguientes matrículas no están inscritas en este taller: ' . implode(', ', $matriculasInvalidas)
            ], 400);
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

        return response()->json(['success' => 'Asistencia registrada correctamente.'], 200);
    }

    public function pasarListaGim(Request $req)
    {
        if (!$req->has('asistencia') || empty($req->asistencia)) {
            return response()->json(['error' => 'No se enviaron datos de asistencia.'], 400);
        }

        $gimnasio = Gimnasios::find($req->gimnasio_id);
        if (!$gimnasio) {
            return response()->json(['error' => 'Gimnasio no encontrado.'], 404);
        }

        $matriculasEnGimnasio = Estudiante::whereIn('matricula', array_keys($req->asistencia))
            ->whereIn('matricula', function ($query) use ($req) {
                $query->select('matricula')
                    ->from('inscripciones_gim')
                    ->where('gimnasio_id', $req->gimnasio_id);
            })
            ->pluck('matricula')
            ->toArray();

        $matriculasInvalidas = array_diff(array_keys($req->asistencia), $matriculasEnGimnasio);
        if (!empty($matriculasInvalidas)) {
            return response()->json([
                'error' => 'Las siguientes matrículas no están inscritas en este taller: ' . implode(', ', $matriculasInvalidas)
            ], 400);
        }

        foreach ($req->asistencia as $matricula => $estado) {
            Asistencias_gim::create([
                'fecha_asistencia' => now(),
                'horas_asignadas' => $req->horas_asignadas ?? 0,
                'gimnasio_id' => $req->gimnasio_id,
                'matricula' => $matricula,
                'estado' => $estado
            ]);
        }

        return response()->json(['success' => 'Asistencia registrada correctamente.'], 200);
    }
}
