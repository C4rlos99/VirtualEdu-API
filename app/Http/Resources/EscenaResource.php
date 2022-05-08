<?php

namespace App\Http\Resources;

use App\Models\Escenario;
use Illuminate\Http\Resources\Json\JsonResource;

class EscenaResource extends JsonResource
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
            "escenario_id" => $this->escenario_id,
            "escena_tipo_id" => $this->escena_tipo_id,
            "respuesta1" => $this->respuesta1,
            "respuesta2" => $this->respuesta2,
            "respuesta3" => $this->respuesta3,
            "escena_id" => $this->escena_id,
            "url_video" => $this->url_video,
            "url_video_apoyo" => $this->url_video_apoyo,
            "url_video_refuerzo" => $this->url_video_refuerzo,
        ];
    }
}
