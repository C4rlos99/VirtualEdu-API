<?php

namespace Database\Seeders;

use App\Models\Lenguaje;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LenguajeSeeder extends Seeder
{
    public function run()
    {
        Lenguaje::factory(9)->create();
    }
}
