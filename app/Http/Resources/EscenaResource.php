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
            "escenarioId" => $this->escenario_id,
            "escenaTipoId" => $this->escena_tipo_id,
            "respuesta1" => $this->respuesta1,
            "respuesta2" => $this->respuesta2,
            "respuesta3" => $this->respuesta3,
            "escenaId" => $this->escena_id,
            "urlVideo" => $this->url_video,
            "urlVideoApoyo" => $this->url_video_apoyo,
            "urlVideoRefuerzo" => $this->url_video_refuerzo,
        ];
    }
}
