<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escena extends Model
{
    use HasFactory;

    protected $fillable = [
        "titulo",
        "escenario_id",
        "escena_tipo_id",
        "respuesta_id",
        "video_id",
        "video_apoyo_id",
        "video_refuerzo_id",
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

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function videoApoyo()
    {
        return $this->belongsTo(Video::class, "video_apoyo_id");
    }

    public function videoRefuerzo()
    {
        return $this->belongsTo(Video::class, "video_refuerzo_id");
    }
}
