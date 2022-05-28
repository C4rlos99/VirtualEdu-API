<?php

namespace Database\Seeders;

use App\Models\Escena;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EscenaSeeder extends Seeder
{
    public function run()
    {
        Escena::factory(100)->create();
    }
}
