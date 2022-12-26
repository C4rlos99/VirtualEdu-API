<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EscenaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "titulo" => $this->titulo,
            "escenario_id" => $this->escenario_id,
            "escena_tipo_id" => $this->escena_tipo_id,
            "respuesta_id" => $this->respuesta_id,
            "video_id" => $this->video_id,
            "video_apoyo_id" => $this->video_apoyo_id,
            "video_refuerzo_id" => $this->video_refuerzo_id,
            "respuestas" => RespuestaResource::collection($this->respuestas),
        ];
    }
}
