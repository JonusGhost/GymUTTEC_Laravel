<?php

namespace App\Http\Controllers;

use App\Models\Talleres;
use App\Models\Docente;
use Illuminate\Http\Request;

class TallerController extends Controller
{
    public function index()
    {
        $talleres = Talleres::get();
        return $talleres;
    }

    public function taller($id) {
        $taller = Talleres::where('id',$id)->first();
        return $taller;
    }

    public function horario($id) {
        $taller = Talleres::where('id', $id)->first();
        if (!$taller) {
            return response()->json(['error' => 'Taller no encontrado'], 404);
        }
        return response()->json($taller->horario);
    }    
    
    public function destroy($id) {
        $taller = Talleres::find($id);
        $taller->delete();
        return 'Ok';;
    }

    public function store(Request $req)
    {
        if($req->id != 0)
        {
            $t_modul = Talleres::find($req->id);
        }else{
            $t_modul = new Talleres();
        }
        $t_modul->nombre_tall = $req->nombre_tall;
        if ($req->hasFile('imagen')) {
            $imagen = $req->file('imagen');
            $rutaImagen = $imagen->store('imagenes_talleres', 'public');
            $t_modul->imagen = $rutaImagen;
        }
        $t_modul->enlace_grupo = $req->enlace_grupo;
        $t_modul->descripcion = $req->descripcion;
        $t_modul->horario = json_decode($req->horario, true);
        $t_modul->num_alumnos = $req->num_alumnos;
        $t_modul->emp_docente = $req->emp_docente;
        $t_modul->save();

        return 'Ok';
    }
    public function asignarDocente(Request $request, $tallerId)
    {
        $request->validate([
            'emp_docente' => 'required|exists:docentes,matricula'
        ]);

        $docente = Docente::where('matricula', $request->emp_docente)->first();

        if ($docente->gimnasio) {
            return response()->json(['error' => 'El docente ya está asignado a un gimnasio'], 400);
        }

        if ($docente->taller) {
            return response()->json(['error' => 'El docente ya está asignado a otro taller'], 400);
        }

        $taller = Talleres::findOrFail($tallerId);
        $taller->emp_docente = $docente->matricula;
        $taller->save();

        return response()->json(['message' => 'Docente asignado con éxito']);
    }
}
