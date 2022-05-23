<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarEscenario;
use App\Http\Requests\ObtenerEscenario;
use App\Http\Resources\EscenarioResource;
use App\Models\Escenario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EscenarioController extends Controller
{
    public function obtenerEscenarios()
    {
        $usuario = Auth::user();

        $escenarios = Escenario::where("usuario_id", $usuario->id, "and")->where("eliminado", false)->get();

        return response()->json([
            "escenarios" => EscenarioResource::collection($escenarios),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function obtenerEscenariosApp(Request $request)
    {
        $usuario = Usuario::where("clave", $request->clave)->first();
        $escenarios = [];

        if ($usuario)
            $escenarios = Escenario::where("usuario_id", $usuario->id, "and")->where("visible", true, "and")->where("eliminado", false)->get();

        return response()->json([
            "escenarios" => EscenarioResource::collection($escenarios),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function obtenerEscenario(ObtenerEscenario $request)
    {
        $escenario = Escenario::findOrFail($request->id);

        return response()->json([
            "escenario" => new EscenarioResource($escenario),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function crearEscenario(GuardarEscenario $request)
    {
        $usuario = Auth::user();

        $escenario = Escenario::create([
            "titulo" => $request->titulo,
            "visible" => $request->visible,
            "usuario_id" => $usuario->id,
            "eliminado" => false,
        ]);

        return response()->json([
            "mensaje" => "Escenario creado",
            "escenario" => new EscenarioResource($escenario),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function modificarEscenario(GuardarEscenario $request)
    {
        $escenario = Escenario::findOrFail($request->id);

        $escenario->update([
            "titulo" => $request->titulo,
            "visible" => $request->visible,
        ]);

        return response()->json([
            "mensaje" => "Escenario modificado",
            "escenario" => new EscenarioResource($escenario),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function eliminarEscenario(GuardarEscenario $request)
    {
        $escenario = Escenario::findOrFail($request->id);

        $escenario->update([
            "eliminado" => true,
        ]);

        return response()->json([
            "mensaje" => "Escenario eliminado",
            "escenario" => new EscenarioResource($escenario),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
