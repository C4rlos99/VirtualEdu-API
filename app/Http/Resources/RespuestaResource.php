<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RespuestaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "escena_id" => $this->escena_id,
            "palabras_correctas" => $this->palabras_correctas,
            "min_correctas" => $this->min_correctas,
            "palabras_incorrectas" => $this->palabras_incorrectas,
            "max_incorrectas" => $this->max_incorrectas,
            "escena" => new EscenaResource($this->escenaHija),
        ];
    }
}
