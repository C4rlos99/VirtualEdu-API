<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escenario extends Model
{
    use HasFactory;

    protected $fillable = [
        "usuario_id",
        "titulo",
        "visible",
        "lenguaje_id",
        "eliminado",
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function escenas()
    {
        return $this->hasMany(Escena::class);
    }

    public function lenguaje()
    {
        return $this->belongsTo(lenguaje::class);
    }

    public function resultados()
    {
        return $this->hasMany(Resultado::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
