<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultadoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "usuario" => new UsuarioResource($this->usuario),
            "escenario_id" => $this->escenario_id,
            "respuestas" => $this->respuestas,
            "fecha_evaluacion" => $this->updated_at,
        ];
    }
}
