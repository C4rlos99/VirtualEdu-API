<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escena extends Model
{
    use HasFactory;

    protected $fillable = [
        "escenario_id",
        "escena_tipo_id",
        "respuesta_id",
        "url_video",
        "url_video_apoyo",
        "url_video_refuerzo",
    ];

    public function escenario()
    {
        return $this->belongsTo(Escenario::class);
    }

    public function escenaTipo()
    {
        return $this->belongsTo(EscenaTipo::class);
    }

    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class);
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }
}
