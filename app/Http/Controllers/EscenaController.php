<?php

namespace App\Http\Controllers;

use App\Http\Requests\EliminarEscena;
use App\Http\Requests\GuardarEscena;
use App\Http\Requests\MostrarEscena;
use App\Http\Requests\MostrarEscenas;
use App\Http\Resources\EscenaResource;
use App\Models\Escena;
use App\Models\Escenario;
use App\Models\EscenaTipo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EscenaController extends Controller
{
    public function obtenerEscenas(MostrarEscenas $request)
    {
        $escenas = Escena::where("escenario_id", $request->escenario_id)->get();

        return EscenaResource::collection($escenas);
    }

    public function obtenerEscena(MostrarEscena $request)
    {
        $escena = Escena::findOrFail($request->id);

        return new EscenaResource($escena);
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

        return response(["mensaje" => "Escena creada"], Response::HTTP_OK);
    }

    public function eliminarEscena(EliminarEscena $request)
    {
        $escena = Escena::findOrFail($request->id);
        $escena->delete();

        return response(["mensaje" => "Escena eliminada"], Response::HTTP_OK);
    }
}
