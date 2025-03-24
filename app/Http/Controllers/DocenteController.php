<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Gimnasios;
use App\Models\Talleres;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DocenteController extends Controller
{
    public function index()
    {
        try {
            $docentes = Docente::with('users')->get();
        
            $docentes->each(function ($docente) {
                $docente->taller = Talleres::where('emp_docente', $docente->matricula)->first();
                $docente->gimnasio = Gimnasios::where('emp_docente', $docente->matricula)->first();
            });
        
            return response()->json($docentes);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }

    public function docent($matricula) {
        $docente = Docente::with('users')->where('matricula', $matricula)->first();
    
        if ($docente) {
            $docente->taller = Talleres::where('emp_docente', $matricula)->first();
            $docente->gimnasio = Gimnasios::where('emp_docente', $matricula)->first();
        }
    
        return response()->json(['docente' => $docente]);
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
        $d_user = Docente::where('matricula', $matricula)->first();

        if (!$d_user) {
            $d_user = new Docente();
            $d_user->matricula = $matricula;

            if (User::where('email', $req->email)->exists()) {
                response()->json(['mensaje' => 'El correo ya está en uso'], 400);
            }

            $user = new User();
            $user->matricula = $matricula;
            $user->rol = 'D';
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            $user->save();
        } else {
            $user = User::where('matricula', $matricula)->first();
            if ($req->filled('password')){
                $user->password = Hash::make($req->password);
                $user->save();
            }
        }

        $d_user->nombre = $req->nombre;
        $d_user->apellido_pat = $req->apellido_pat;
        $d_user->apellido_mat = $req->apellido_mat;
        $d_user->num_celular = $req->num_celular;
        $d_user->afili_seguro = $req->afili_seguro;
        $d_user->especialidad = $req->especialidad;
        $d_user->save();

        return response()->json([
            'mensaje' => 'Docente guardado',
            'docente' => $d_user
        ], 201);
    }
}
