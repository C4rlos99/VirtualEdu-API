<?php

namespace Database\Factories;

use App\Models\Escenario;
use App\Models\EscenaTipo;
use App\Models\Respuesta;
use Illuminate\Database\Eloquent\Factories\Factory;

class EscenaFactory extends Factory
{
    public function definition()
    {
        $escenarios = Escenario::pluck("id")->toArray();
        $escena_tipos = EscenaTipo::pluck("id")->toArray();
        $respuestas = Respuesta::all()->pluck("id")->toArray();

        return [
            "escenario_id" => $this->faker->randomElement($escenarios),
            "escena_tipo_id" => $this->faker->randomElement($escena_tipos),
            "escena_id" => $this->faker->randomElement($respuestas),
            "url_video" => $this->faker->word(),
            "url_video_apoyo" => $this->faker->word(),
            "url_video_refuerzo" => $this->faker->word(),
        ];
    }
}
