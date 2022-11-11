<?php

namespace App\Http\Resources;

use App\Models\Escenario;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultadoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "nombre_usuario" => (new UsuarioResource($this->usuario))->nombre . " " . (new UsuarioResource($this->usuario))->apellidos,
            "titulo_escenario" => (new EscenarioResource($this->escenario))->titulo,
            "respuestas" => $this->respuestas,
            "fecha_evaluacion" => $this->updated_at,
        ];
    }
}
