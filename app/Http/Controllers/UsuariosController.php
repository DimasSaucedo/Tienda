<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    //
    public function index()
    {
        $usuarios = User::all();
        return view('Usuarios.index', compact('usuarios'));
    }

    public function habilitar_usuario(Request $request)
    {
        $usuario = User::where('id', $request->id_usuario)->first();
        $usuario->estado = 1;
        $continuar = $usuario->update();

        if ($continuar) {
            $estado = "success";
            $mensaje = "Usuario habilitado correctamente";

            return redirect('/usuarios')->with($estado, $mensaje);
        } else {
            $estado = "error";
            $mensaje = "No se habilito el usuario";

            return redirect('/usuarios')->with($estado, $mensaje);
        }
    }

    public function deshabilitar_usuario(Request $request)
    {
        $usuario = User::where('id', $request->id_usuario)->first();
        $usuario->estado = 0;
        $continuar = $usuario->update();

        if ($continuar) {
            $estado = "success";
            $mensaje = "Usuario habilitado correctamente";

            return redirect('/usuarios')->with($estado, $mensaje);
        } else {
            $estado = "error";
            $mensaje = "No se habilito el usuario";

            return redirect('/usuarios')->with($estado, $mensaje);
        }
    }

    public function editar_usuario(Request $request) {
        return view('usuarios.editar_usuario');
    }
}
