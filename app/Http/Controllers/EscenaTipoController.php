<?php

namespace App\Http\Controllers;

use App\Http\Resources\EscenaTipoResource;
use App\Models\EscenaTipo;
use Symfony\Component\HttpFoundation\Response;

class EscenaTipoController extends Controller
{
    public function obtenerEscenaTipos()
    {
        $escenas_tipos = EscenaTipo::all();

        return response()->json([
            "escena_tipos" => EscenaTipoResource::collection($escenas_tipos),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
