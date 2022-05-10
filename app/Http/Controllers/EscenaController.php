<?php

namespace App\Http\Controllers;

use App\Http\Requests\EliminarEscena;
use App\Http\Requests\GuardarEscena;
use App\Http\Requests\ObtenerEscena;
use App\Http\Requests\ObtenerEscenas;
use App\Http\Resources\EscenaResource;
use App\Models\Escena;
use Symfony\Component\HttpFoundation\Response;

class EscenaController extends Controller
{
    public function obtenerEscenas(ObtenerEscenas $request)
    {
        $escenas = Escena::where("escenario_id", $request->escenario_id)->get();

        return response()->json([
            "escenas" => EscenaResource::collection($escenas),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function obtenerEscena(ObtenerEscena $request)
    {
        $escena = Escena::findOrFail($request->id);

        return response()->json([
            "escena" => new EscenaResource($escena),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function crearEscena(GuardarEscena $request)
    {
        $escena = Escena::create([
            "escenario_id" => $request->escenario_id,
            "escena_tipo_id" => $request->escena_tipo_id,
            "respuesta1" => $request->respuesta1,
            "respuesta2" => $request->respuesta2,
            "respuesta3" => $request->respuesta3,
            "escena_id" => $request->escena_id,
            "url_video" => $request->url_video,
            "url_video_apoyo" => $request->url_video_apoyo,
            "url_video_refuerzo" => $request->url_video_refuerzo,
        ]);

        $escena->save();

        return response()->json([
            "mensaje" => "Escena creada",
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function modificarEscena(GuardarEscena $request)
    {
        $escena = Escena::findOrFail($request->id);

        $escena->update([
            "escena_tipo_id" => $request->escena_tipo_id,
            "respuesta1" => $request->respuesta1,
            "respuesta2" => $request->respuesta2,
            "respuesta3" => $request->respuesta3,
            "url_video" => $request->url_video,
            "url_video_apoyo" => $request->url_video_apoyo,
            "url_video_refuerzo" => $request->url_video_refuerzo,
        ]);

        return response()->json([
            "mensaje" => "Escena modificada",
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function eliminarEscena(EliminarEscena $request)
    {
        $escena = Escena::findOrFail($request->id);
        $escena->delete();

        return response()->json([
            "mensaje" => "Escena eliminada",
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
