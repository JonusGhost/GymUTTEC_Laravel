<?php

namespace App\Http\Controllers;

use App\Models\Gimnasios;
use App\Models\Docente;
use Illuminate\Http\Request;

class GimnasioController extends Controller
{
    public function index()
    {
        $gimnasios = Gimnasios::get();
        return $gimnasios;
    }

    public function gimnasio($id) {
        $gimnasio = Gimnasios::where('id',$id)->first();
        return $gimnasio;
    }

    public function horario($id) {
        $gimnasio = Gimnasios::where('id', $id)->first();
        if (!$gimnasio) {
            return response()->json(['error' => 'Gimnasio no encontrado'], 404);
        }
        return response()->json($gimnasio->horario);
    }    

    public function destroy($id) {
        $gimnasio = Gimnasios::find($id);
        $gimnasio->delete();
        return 'Ok';
    }

    public function store(Request $req)
    {
        if($req->id != 0)
        {
            $g_modul = Gimnasios::find($req->id);
        }else{
            $g_modul = new Gimnasios();
        }
        $g_modul->nombre_gim = $req->nombre_gim;
        if ($req->hasFile('imagen')) {
            $imagen = $req->file('imagen');
            $rutaImagen = $imagen->store('imagenes_talleres', 'public');
            $g_modul->imagen = $rutaImagen;
        }
        $g_modul->enlace_grupo = $req->enlace_grupo;
        $g_modul->descripcion = $req->descripcion;
        $g_modul->horario = json_decode($req->horario, true);
        $g_modul->num_alumnos = $req->num_alumnos;
        $g_modul->emp_docente = $req->emp_docente;
        $g_modul->save();

        return 'Ok';
    }

    public function asignarDocente(Request $request, $gimnasioId)
    {
        $request->validate([
            'emp_docente' => 'required|exists:docentes,matricula'
        ]);

        $docente = Docente::where('matricula', $request->emp_docente)->first();

        if ($docente->gimnasio) {
            return response()->json(['error' => 'El docente ya está asignado a otro gimnasio'], 400);
        }

        if ($docente->taller) {
            return response()->json(['error' => 'El docente ya está asignado a un taller'], 400);
        }

        $gimnasio = Gimnasios::findOrFail($gimnasioId);
        $gimnasio->emp_docente = $docente->matricula;
        $gimnasio->save();

        return response()->json(['message' => 'Docente asignado con éxito']);
    }
}
