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

    public function update(Request $req, $matricula)
    {
        $docente = Docente::where('matricula', $matricula)->first();

        if (!$docente) {
            return response()->json(['mensaje' => 'Docente no encontrado'], 404);
        }

        // Update docente information
        $docente->nombre = $req->filled('nombre') ? $req->nombre : $docente->nombre;
        $docente->apellido_pat = $req->filled('apellido_pat') ? $req->apellido_pat : $docente->apellido_pat;
        $docente->apellido_mat = $req->filled('apellido_mat') ? $req->apellido_mat : $docente->apellido_mat;
        $docente->num_celular = $req->filled('num_celular') ? $req->num_celular : $docente->num_celular;
        $docente->afili_seguro = $req->filled('afili_seguro') ? $req->afili_seguro : $docente->afili_seguro;
        $docente->especialidad = $req->filled('especialidad') ? $req->especialidad : $docente->especialidad;
        $docente->save();

        // Get user data to include email in response
        $userData = User::where('matricula', $matricula)->first(['email']);

        return response()->json([
            'mensaje' => 'Docente actualizado',
            'docente' => $docente,
            'email' => $userData->email
        ], 200);
    }

    public function docent($matricula) {
        $docente = Docente::where('matricula', $matricula)->first();
        if (!$docente) {
            return response()->json(['mensaje' => 'Docente no encontrado'], 404);
        }

        // Get user email
        $userData = User::where('matricula', $matricula)->first(['email']);

        // Combine docente and email data
        $response = $docente->toArray();
        $response['email'] = $userData->email;

        return response()->json($response);
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
                response()->json(['mensaje' => 'El correo ya está en uso'], 400);
            }

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
