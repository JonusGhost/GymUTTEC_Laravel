<?php

namespace App\Http\Controllers;

use App\Models\Gimnasios;
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

    public function destroy($id) {
        $gimnasio = Gimnasios::find($id);
        $gimnasio->delete();
        return 'Ok';;
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
        $g_modul->emp_docente_1 = $req->emp_docente_1;
        $g_modul->emp_docente_2 = $req->emp_docente_2;
        $g_modul->emp_docente_3 = $req->emp_docente_3;
        $g_modul->save();

        return 'Ok';
    }
}
