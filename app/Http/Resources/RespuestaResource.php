<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RespuestaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "valores" => $this->valores,
            "escena_id" => $this->escena_id,
            "escena" => new EscenaResource($this->escenaHija),
        ];
    }
}
