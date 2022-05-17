<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EscenarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "titulo" => $this->titulo,
            "visible" => $this->visible,
            "eliminado" => $this->eliminado,
            "fecha_creacion" => $this->updated_at,
        ];
    }
}
