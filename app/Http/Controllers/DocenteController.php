<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::get();
        return $docentes;
    }

    public function docent($matricula) {
        $estudiante = Docente::where('matricula',$matricula)->first();
        return $estudiante;
    }

    public function destroy($matricula) {
        $user = User::find($matricula);
        if ($user){
            $admin = Docente::where('matricula',$matricula)->first();
            if ($admin){
                $admin->delete();
            }
            $user->delete();
            return 'Ok';
        }
        return 'Usuario no encontrado';
    }

    public function store(Request $req)
    {
        $matricula = trim($req->matricula);
        $a_user = Docente::where('matricula', $matricula)->first();

        if (!$a_user) {
            $d_user = new Docente();
            $d_user->matricula = $matricula;

            $user = new User();
            $user->matricula = $matricula;
            $user->rol = 'D';
            $user->email = $req->email;

            if (User::where('email', $req->email)->exists()) {
                return 'El correo ya está en uso';
            }

            $user->password = Hash::make($req->password);
            $user->save();
        }

        $d_user->nombre = $req->nombre;
        $d_user->apellido_pat = $req->apellido_pat;
        $d_user->apellido_mat = $req->apellido_mat;
        $d_user->num_celular = $req->num_celular;
        $d_user->afili_seguro = $req->afili_seguro;    
        $d_user->especialidad = $req->especialidad;
        $d_user->save();

        return 'Ok';
    }
}
