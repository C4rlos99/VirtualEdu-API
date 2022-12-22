<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        "escenario_id",
        "nombre",
        "localizacion",
    ];

    public function escenas()
    {
        return $this->hasMany(Escena::class);
    }

    public function escenasApoyo()
    {
        return $this->hasMany(Escena::class, "video_apoyo_id");
    }

    public function escenasRefuerzo()
    {
        return $this->hasMany(Escena::class, "video_refuerzo_id");
    }

    public function escenario()
    {
        return $this->belongsTo(Escenario::class);
    }
}
