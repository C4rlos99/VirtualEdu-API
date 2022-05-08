<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Escenario>
 */
class EscenarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $usuarios = Usuario::pluck("id")->toArray();

        return [
            "titulo" => $this->faker->word(),
            "visible" => $this->faker->boolean(),
            "usuario_id" => $this->faker->randomElement($usuarios),
        ];
    }
}