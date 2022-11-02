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
            "url_video" => $this->url_video,
            "url_video_apoyo" => $this->url_video_apoyo,
            "url_video_refuerzo" => $this->url_video_refuerzo,
            "respuestas" => RespuestaResource::collection($this->respuestas),
        ];
    }
}
