<?php

namespace App\Http\Controllers;

use App\Http\Resources\EscenaTipoResource;
use App\Models\EscenaTipo;
use Illuminate\Http\Request;

class EscenaTipoController extends Controller
{
    public function obtenerTipos()
    {
        $escenas_tipos = EscenaTipo::all();

        return EscenaTipoResource::collection($escenas_tipos);
    }
}
