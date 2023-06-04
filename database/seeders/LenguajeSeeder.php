<?php

namespace Database\Seeders;

use App\Models\Lenguaje;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LenguajeSeeder extends Seeder
{
    public function run()
    {
        DB::table("lenguajes")->insert([
            "nombre" => "Español",
            "codigo" => "es-ES",
        ]);
        DB::table("lenguajes")->insert([
            "nombre" => "Alemán",
            "codigo" => "de-DE",
        ]);
        DB::table("lenguajes")->insert([
            "nombre" => "Inglés",
            "codigo" => "en-EN",
        ]);
        DB::table("lenguajes")->insert([
            "nombre" => "Portugués",
            "codigo" => "pt-PT",
        ]);
        DB::table("lenguajes")->insert([
            "nombre" => "Francés",
            "codigo" => "fr-FR",
        ]);
    }
}
