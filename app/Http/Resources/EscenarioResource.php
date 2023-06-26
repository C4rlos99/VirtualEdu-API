<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EscenarioResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "titulo" => $this->titulo,
            "visible" => $this->visible,
            "eliminado" => $this->eliminado,
            "lenguaje_id" => $this->lenguaje_id,
            // "lenguaje_codigo" => (new LenguajeResource($this->lenguaje))->codigo,
            "spread_sheet_id" => (new UsuarioResource($this->usuario))->spread_sheet_id,
            "videos" => VideoResource::collection($this->videos),
            "fecha_creacion" => $this->updated_at,
        ];
    }
}
