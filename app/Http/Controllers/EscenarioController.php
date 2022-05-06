<?php

namespace App\Http\Controllers;

use App\Http\Resources\EscenarioResource;
use App\Models\Escenario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EscenarioController extends Controller
{
    public function obtenerEscenarios(Request $request)
    {
        $escenarios = Escenario::where("usuario_id", $request->usuario_id)->get();

        return EscenarioResource::collection($escenarios);
    }

    public function obtenerEscenario(Request $request)
    {
        $escenario = Escenario::find($request->id);

        return new EscenarioResource($escenario);
    }

    public function crearEscenario(Request $request)
    {
        $usuario = Usuario::find($request->usuario_id);

        $escenario = Escenario::create([
            "titulo" => $request->titulo,
            "visible" => $request->visible,
            "usuario_id" => $usuario->id,
        ]);

        $usuario->escenarios()->save($escenario);
        $usuario->refresh();

        $escenario->usuario()->associate($usuario);
        $escenario->save();
    }

    public function eliminarEscenario(Request $request)
    {
        $escenario = Escenario::find($request->id);
        $escenario->delete();

        return response(["mensaje" => "eliminado"], Response::HTTP_OK);
    }
}
