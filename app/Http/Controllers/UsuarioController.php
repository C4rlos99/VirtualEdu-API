<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function crearUsuario(Request $request)
    {
        $usuario = Usuario::create([
            "nombre" => $request->input("nombre"),
            "apellidos" => $request->input("apellidos"),
            "correo" => $request->input("correo"),
            "clave" => $request->input("clave"),
            "password" => $request->input("password"),
        ]);
    }
}
