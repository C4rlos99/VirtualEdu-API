<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lenguaje extends Model
{
    use HasFactory;

    protected $fillable = [
        "nombre",
    ];

    public function escenarios()
    {
        return $this->hasMany(Escenario::class);
    }
}
