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
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function escenas()
    {
        return $this->hasMany(Escena::class);
    }
}
