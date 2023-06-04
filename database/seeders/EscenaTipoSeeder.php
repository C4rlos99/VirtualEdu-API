<?php

namespace Database\Seeders;

use App\Models\EscenaTipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EscenaTipoSeeder extends Seeder
{
    public function run()
    {
        DB::table("escena_tipos")->insert([
            "nombre" => "Escena simple",
        ]);
        DB::table("escena_tipos")->insert([
            "nombre" => "Escena con video de apoyo",
        ]);
        DB::table("escena_tipos")->insert([
            "nombre" => "Escena con video de apoyo y refuerzo",
        ]);
        DB::table("escena_tipos")->insert([
            "nombre" => "Escena con múltiples respuestas",
        ]);
    }
}
