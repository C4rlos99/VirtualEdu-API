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
        $escenas = $this->hasMany(Escena::class);
        $escenas_apoyo = $this->hasMany(Escena::class, "video_apoyo_id");
        $escenas_refuerzo = $this->hasMany(Escena::class, "video_refuerzo_id");

        return $escenas->merge($escenas_apoyo->merge($escenas_refuerzo));
    }

    public function escenario()
    {
        return $this->belongsTo(Escenario::class);
    }
}
