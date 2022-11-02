<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = [
        "usuario_id",
        "escenario_id",
        "respuestas",
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function escenario()
    {
        return $this->belongsTo(Escenario::class);
    }
}
