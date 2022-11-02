<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultadoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "usuario_id" => $this->usuario_id,
            "escenario_id" => $this->escenario_id,
            "fecha_evaluacion" => $this->updated_at,
        ];
    }
}
