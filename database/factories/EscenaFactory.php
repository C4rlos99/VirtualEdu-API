<?php

namespace Database\Factories;

use App\Models\Escena;
use App\Models\Escenario;
use App\Models\EscenaTipo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Escena>
 */
class EscenaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $escenarios = Escenario::pluck("id")->toArray();
        $escena_tipos = EscenaTipo::pluck("id")->toArray();

        return [
            "escenario_id" => $this->faker->randomElement($escenarios),
            "escena_tipo_id" => $this->faker->randomElement($escena_tipos),
            "respuesta1" => $this->faker->word(),
            "respuesta2" => $this->faker->word(),
            "respuesta3" => $this->faker->word(),
            "escena_id" => $this->faker->numberBetween(1, 100),
            "url_video" => $this->faker->word(),
            "url_video_apoyo" => $this->faker->word(),
            "url_video_refuerzo" => $this->faker->word(),
        ];
    }
}
