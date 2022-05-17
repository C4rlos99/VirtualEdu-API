<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        "escena_id",
        "valores",
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
