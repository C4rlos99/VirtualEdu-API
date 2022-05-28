<?php

namespace Database\Seeders;

use App\Models\Escenario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EscenarioSeeder extends Seeder
{
    public function run()
    {
        Escenario::factory(10)->create();
    }
}
