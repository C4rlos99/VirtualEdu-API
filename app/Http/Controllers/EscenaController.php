<?php

namespace App\Http\Controllers;

use App\Http\Resources\EscenaResource;
use App\Models\Escena;
use App\Models\Escenario;
use App\Models\EscenaTipo;
use Illuminate\Http\Request;

class EscenaController extends Controller
{
    public function obtenerEscenas($escenario_id)
    {
        $escenas = Escena::where("escenario_id", $escenario_id)->get();

        return EscenaResource::collection($escenas);
    }

    public function obtenerEscena($id)
    {
        $escena = Escena::find($id);

        return new EscenaResource($escena);
    }

    public function crearEscena(Request $request)
    {
        $escenario = Escenario::find($request->escenario_id);
        if ($request->escena_id)
            $escena_padre = Escena::find($request->escena_id);
        $escena_tipo = EscenaTipo::find($request->escena_tipo_id);

        $escena = Escena::create([
            "escenario_id" => $escenario->id,
            "escena_tipo_id" => $escena_tipo->id,
            "respuesta1" => $request->input("respuesta1"),
            "respuesta2" => $request->input("respuesta2"),
            "respuesta3" => $request->input("respuesta3"),
            "escena_id" => $request->input("escena_id"),
            "url_video" => $request->input("url_video"),
            "url_video_apoyo" => $request->input("url_video_apoyo"),
            "url_video_refuerzo" => $request->input("url_video_refuerzo"),
        ]);

        $escenario->escenas()->save($escena);
        $escenario->refresh();

        $escena_tipo->escenas()->save($escena);
        $escena_tipo->refresh();

        $escena->escenario()->associate($escenario);

        if ($request->escena_id !== null) {
            $escena_padre->escenas()->save($escena);
            $escena_padre->refresh();
            $escena->escena()->associate($escena_padre);
        }

        $escena->escenaTipo()->associate($escena_tipo);

        $escena->save();

        return new EscenaResource($escena);
    }
}
