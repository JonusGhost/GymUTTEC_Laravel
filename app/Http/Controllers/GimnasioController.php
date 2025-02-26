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

    public function store(Request $req)
    {
        if($req->id != 0)
        {
            $g_modul = Gimnasios::find($req->id);
        }else{
            $g_modul = new Gimnasios();
        }
        $g_modul->nombre_gim = $req->nombre_gim;
        $g_modul->descripcion = $req->descripcion;
        $g_modul->horario = $req->horario;
        $g_modul->num_alumnos = $req->num_alumnos;
        $g_modul->enlace_grupo = $req->enlace_grupo;
        $g_modul->emp_docente_1 = $req->emp_docente_1;
        $g_modul->emp_docente_2 = $req->emp_docente_2;
        $g_modul->emp_docente_3 = $req->emp_docente_3;
        $g_modul->save();

        return 'Ok';
    }
}
