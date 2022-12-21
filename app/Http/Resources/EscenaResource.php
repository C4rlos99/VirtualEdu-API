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
            "video_id" => new VideoResource($this->video),
            "video_apoyo_id" => new VideoResource($this->videoApoyo),
            "video_refuerzo_id" => new VideoResource($this->videoRefuerzo),
            "respuestas" => RespuestaResource::collection($this->respuestas),
        ];
    }
}
