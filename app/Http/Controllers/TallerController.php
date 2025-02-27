<?php

namespace App\Http\Controllers;

use App\Models\Talleres;
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
        $t_modul->descripcion = $req->descripcion;
        $t_modul->horario = $req->horario;
        $t_modul->num_alumnos = $req->num_alumnos;
        $t_modul->enlace_grupo = $req->enlace_grupo;
        $t_modul->emp_docente = $req->emp_docente;
        $t_modul->save();

        return 'Ok';
    }
}
