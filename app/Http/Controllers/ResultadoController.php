<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarResultado;
use App\Http\Requests\ObtenerResultados;
use App\Http\Resources\ResultadoResource;
use App\Models\Escenario;
use App\Models\Resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ResultadoController extends Controller
{
    public function obtenerResultados(ObtenerResultados $request)
    {
        $resultados = Resultado::where("escenario_id", $request->escenario_id)->get();

        $escenario = Escenario::findOrFail($request->escenario_id);

        return response()->json([
            "resultados" => [ResultadoResource::collection($resultados), "escenario_titulo" => $escenario->titulo],
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function crearResultado(GuardarResultado $request)
    {
        $usuario = Auth::user();

        $resultado = Resultado::create([
            "usuario_id" => $usuario->id,
            "escenario_id" => $request->escenario_id,
            "respuestas" => $request->respuestas,
        ]);

        return response()->json([
            "mensaje" => "Resultado creado",
            "resultado" => new ResultadoResource($resultado),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function modificarResultado(GuardarResultado $request)
    {
        $resultado =  Resultado::findOrFail($request->id);

        $resultado->update([
            "respuestas" => $request->respuestas,
        ]);

        return response()->json([
            "mensaje" => "Resultado modificado",
            "resultado" => new ResultadoResource($resultado),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function existeResultado(Request $request)
    {
        $usuario = Auth::user();

        $existeResultado = Resultado::where("usuario_id", $usuario->id, "and")->where("escenario_id", $request->escenario_id)->exists();

        return response()->json([
            "existe" => $existeResultado,
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
