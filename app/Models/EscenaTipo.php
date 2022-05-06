<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class EscenaTipo extends Model
{
    use HasFactory;

    protected $fillable = [
        "nombre",
    ];

    public function escenas()
    {
        return $this->hasMany(Escena::class);
    }
}
