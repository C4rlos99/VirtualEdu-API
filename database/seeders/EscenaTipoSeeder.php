<?php

namespace Database\Seeders;

use App\Models\EscenaTipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EscenaTipoSeeder extends Seeder
{
    public function run()
    {
        EscenaTipo::factory(4)->create();
    }
}
