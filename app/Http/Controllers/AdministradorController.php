<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Gimnasios;
use App\Models\Talleres;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministradorController extends Controller
{
    public function index()
    {
        $administradores = Administrador::get();
        return $administradores;
    }

    public function admin($matricula) {
        $administrador = Administrador::where('matricula',$matricula)->first();
        return $administrador;
    }

    public function destroy($matricula) {
        $user = User::find($matricula);
        if ($user){
            $admin = Administrador::where('matricula',$matricula)->first();
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
        $a_user = Administrador::where('matricula', $matricula)->first();

        if (!$a_user) {
            $a_user = new Administrador();
            $a_user->matricula = $matricula;

            $user = new User();
            $user->matricula = $matricula;
            $user->rol = 'A';
            $user->email = $req->email;

            if (User::where('email', $req->email)->exists()) {
                response()->json(['mensaje' => 'El correo ya está en uso'], 400);
            }

            $user->password = Hash::make($req->password);
            $user->save();
        }

        $a_user->nombre = $req->nombre;
        $a_user->apellido_pat = $req->apellido_pat;
        $a_user->apellido_mat = $req->apellido_mat;
        $a_user->num_celular = $req->num_celular;
        $a_user->afili_seguro = $req->afili_seguro;
        $a_user->save();

        return response()->json([
            'mensaje' => 'Administrador guardado',
            'administrador' => $a_user
        ], 201);
    }

    public function altaT($matricula, $taller_id)
    {
        $taller = Talleres::findOrFail($taller_id);
        $taller->emp_docente = $matricula;
        $taller->save();

        return 'Docente asignado al taller correctamente.';
    }

    public function bajaT(Request $req)
    {
        $validated = $req->validate([
            'taller_id' => 'required|exists:talleres,id',
            'docente_id' => 'required|exists:docentes,matricula',
        ]);
        $taller = Talleres::findOrFail($validated['taller_id']);
        if ($taller->emp_docente == $validated['docente_id']) {
            $taller->emp_docente = null;
        } else {
            return 'El docente no está asignado a este taller.';
        }
        $taller->save();
        return 'Ok';
    }

    public function altaG(Request $req)
    {
        $validated = $req->validate([
            'gimnasio_id' => 'required|exists:gimnasios,id',
            'docente_ids' => 'required|array|min:1|max:3',
            'docente_ids.*' => 'exists:docentes,matricula',
        ]);

        $gimnasio = Gimnasios::findOrFail($validated['gimnasio_id']);
        $gimnasio->emp_docente_1 = $validated['docente_ids'][0] ?? null;
        $gimnasio->emp_docente_2 = $validated['docente_ids'][1] ?? null;
        $gimnasio->emp_docente_3 = $validated['docente_ids'][2] ?? null;
        $gimnasio->save();
        return 'Ok';
    }

    public function bajaG(Request $req)
    {
        $validated = $req->validate([
            'gimnasio_id' => 'required|exists:gimnasios,id',
            'docente_id' => 'required|exists:docentes,matricula',
        ]);
        $gimnasio = Gimnasios::findOrFail($validated['gimnasio_id']);
        if ($gimnasio->emp_docente_1 == $validated['docente_id']) {
            $gimnasio->emp_docente_1 = null;
        } elseif ($gimnasio->emp_docente_2 == $validated['docente_id']) {
            $gimnasio->emp_docente_2 = null;
        } elseif ($gimnasio->emp_docente_3 == $validated['docente_id']) {
            $gimnasio->emp_docente_3 = null;
        } else {
            return 'El docente no está asignado a este gimnasio.';
        }
        $gimnasio->save();
        return 'Ok';
    }
}
