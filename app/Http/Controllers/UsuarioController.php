<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarUsuario;
use App\Http\Requests\StoreUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UsuarioController extends Controller
{
    public function registrar(GuardarUsuario $request)
    {
        $usuario = Usuario::create([
            "nombre" => $request->nombre,
            "apellidos" => $request->apellidos,
            "correo" => $request->correo,
            "clave" => Str::random(8),
            "password" => Hash::make($request->password),
        ]);

        $usuario->save();

        return response()->json([
            "mensaje" => "Usuario registrado",
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function iniciarSesion(Request $request)
    {
        if (!Auth::attempt($request->only("correo", "password"))) {
            return response()->json([
                "mensaje" => "Credenciales inválidas",
                "status" => Response::HTTP_UNAUTHORIZED
            ], Response::HTTP_UNAUTHORIZED);
        }

        $usuario = Auth::user();

        $token = $usuario->createToken("token")->plainTextToken;

        $cookie = cookie("jwt", $token, 60 * 24);

        return response()->json([
            "mensaje" => "Sesión iniciada",
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK)->withCookie($cookie);
    }

    public function usuario()
    {
        return Auth::user();
    }

    public function cerrarSesion()
    {
        $cookie = Cookie::forget("jwt");

        return response()->json([
            "mensaje" => "Sesion cerrada",
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK)->withCookie($cookie);
    }
}
