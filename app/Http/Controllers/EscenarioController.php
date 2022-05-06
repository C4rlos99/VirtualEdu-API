<?php

namespace App\Http\Controllers;

use App\Http\Resources\EscenarioResource;
use App\Models\Escenario;
use App\Models\Usuario;
use Illuminate\Http\Request;

class EscenarioController extends Controller
{
    public function obtenerEscenarios($usuario_id)
    {
        $escenarios = Escenario::where("usuario_id", $usuario_id)->get();

        return EscenarioResource::collection($escenarios);
    }

    public function obtenerEscenario($id)
    {
        $escenario = Escenario::find($id);

        return new EscenarioResource($escenario);
    }

    public function crearEscenario(Request $request)
    {
        $usuario = Usuario::find($request->usuario_id);

        $escenario = Escenario::create([
            "titulo" => $request->input("titulo"),
            "visible" => $request->input("visible"),
            "usuario_id" => $usuario->id,
        ]);

        $usuario->escenarios()->save($escenario);
        $usuario->refresh();

        $escenario->usuario()->associate($usuario);
        $escenario->save();

        return new EscenarioResource($escenario);
    }

    public function eliminarEscenario($id)
    {
        $escenario = Escenario::find($id);
        $escenario->delete();
    }
}
