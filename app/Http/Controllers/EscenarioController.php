<?php

namespace App\Http\Controllers;

use App\Http\Requests\EliminarEscenario;
use App\Http\Requests\GuardarEscenario;
use App\Http\Requests\ObtenerEscenario;
use App\Http\Requests\ObtenerEscenarios;
use App\Http\Resources\EscenarioResource;
use App\Models\Escenario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EscenarioController extends Controller
{
    public function obtenerEscenarios(ObtenerEscenarios $request)
    {
        $escenarios = Escenario::where("usuario_id", $request->usuario_id)->get();

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
            $escenarios = Escenario::where("usuario_id", $usuario->id, "and")->where("visible", true)->get();

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
        $escenario = Escenario::create([
            "titulo" => $request->titulo,
            "visible" => $request->visible,
            "usuario_id" => $request->usuario_id,
        ]);

        $escenario->save();

        return response()->json([
            "mensaje" => "Escenario creado",
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
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function eliminarEscenario(EliminarEscenario $request)
    {
        $escenario = Escenario::findOrFail($request->id);
        $escenario->delete();

        return response()->json([
            "mensaje" => "Escenario eliminado",
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
