<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UsuarioController extends Controller
{
    public function registrar(Request $request)
    {
        $usuario = Usuario::create([
            "nombre" => $request->nombre,
            "apellidos" => $request->apellidos,
            "correo" => $request->correo,
            "clave" => $request->clave,
            "password" => Hash::make($request->password),
        ]);

        return $usuario;
    }

    public function iniciarSesion(Request $request)
    {
        if (!Auth::attempt($request->only("correo", "password"))) {
            return response(["mensaje" => "Credenciales inválidas"], Response::HTTP_UNAUTHORIZED);
        }

        $usuario = Auth::user();

        $token = $usuario->createToken("token")->plainTextToken;

        $cookie = cookie("jwt", $token, 60 * 24);

        return response(["mensaje" => "Sesión iniciada"])->withCookie($cookie);
    }

    public function usuario()
    {
        return Auth::user();
    }

    public function cerrarSesion()
    {
        $cookie = Cookie::forget("jwt");

        return response(["mensaje" => "Sesion cerrada"])->withCookie($cookie);
    }
}
