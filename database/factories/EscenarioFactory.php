<?php

namespace Database\Factories;

use App\Models\Lenguaje;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Escenario>
 */
class EscenarioFactory extends Factory
{
    public function definition()
    {
        $usuarios = Usuario::pluck("id")->toArray();
        $lenguajes = Lenguaje::pluck("id")->toArray();

        return [
            "titulo" => $this->faker->word(),
            "visible" => $this->faker->boolean(),
            "usuario_id" => $this->faker->randomElement($usuarios),
            "lenguaje_id" => $this->faker->randomElement($lenguajes),
        ];
    }
}
