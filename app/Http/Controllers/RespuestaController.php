<?php

namespace App\Http\Controllers;

use App\Http\Requests\EliminarRespuesta;
use App\Http\Requests\GuardarRespuesta;
use App\Models\Respuesta;
use Symfony\Component\HttpFoundation\Response;

class RespuestaController extends Controller
{
    public function crearRespuesta(GuardarRespuesta $request)
    {
        $respuesta = Respuesta::create([
            "escena_id" => $request->escena_id,
            "palabras_correctas" => $request->palabras_correctas,
            "min_correctas" => $request->min_correctas,
            "palabras_incorrectas" => $request->palabras_incorrectas,
            "max_incorrectas" => $request->max_incorrectas,
        ]);

        return response()->json([
            "mensaje" => "Respuesta creada",
            "respuesta" => $respuesta,
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function modificarRespuesta(GuardarRespuesta $request)
    {
        $respuesta = Respuesta::findOrFail($request->id);

        $respuesta->update([
            "palabras_correctas" => $request->palabras_correctas,
            "min_correctas" => $request->min_correctas,
            "palabras_incorrectas" => $request->palabras_incorrectas,
            "max_incorrectas" => $request->max_incorrectas,
        ]);

        return response()->json([
            "mensaje" => "Respuesta modificada",
            "respuesta" => $respuesta,
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function eliminarRespuesta(EliminarRespuesta $request)
    {
        $respuesta = Respuesta::findOrFail($request->id);

        $respuesta->delete();

        return response()->json([
            "mensaje" => "Respuesta eliminada",
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
