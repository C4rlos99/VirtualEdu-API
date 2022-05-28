<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        "escena_id",
        "palabras_correctas",
        "min_correctas",
        "palabras_incorrectas",
        "max_incorrectas",
    ];

    public function escena()
    {
        return $this->belongsTo(Escena::class);
    }

    public function escenaHija()
    {
        return $this->hasOne(Escena::class);
    }
}
