<?php

namespace App\Http\Controllers;

use App\Http\Requests\EliminarEscenario;
use App\Http\Requests\GuardarEscenario;
use App\Http\Requests\MostrarEscenario;
use App\Http\Requests\MostrarEscenarios;
use App\Http\Resources\EscenarioResource;
use App\Models\Escenario;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EscenarioController extends Controller
{
    public function obtenerEscenarios(MostrarEscenarios $request)
    {
        $escenarios = Escenario::where("usuario_id", $request->usuario_id)->get();

        return response()->json([
            "escenarios" => EscenarioResource::collection($escenarios),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function obtenerEscenario(MostrarEscenario $request)
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
