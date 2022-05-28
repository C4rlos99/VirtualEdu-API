<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LenguajeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "nombre" => $this->nombre
        ];
    }
}
