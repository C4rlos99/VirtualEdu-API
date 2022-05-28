<?php

namespace App\Http\Controllers;

use App\Http\Resources\LenguajeResource;
use App\Models\Lenguaje;
use Symfony\Component\HttpFoundation\Response;

class LenguajeController extends Controller
{
    public function obtenerLenguajes()
    {
        $lenguajes = Lenguaje::all();

        return Response()->json([
            "lenguajes" =>  LenguajeResource::collection($lenguajes),
            "status" => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }
}
