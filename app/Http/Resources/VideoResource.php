<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "escenario_id" => $this->escenario_id,
            "nombre" => $this->nombre,
            "localizacion" => $this->localizacion,
        ];
    }
}
