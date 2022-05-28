<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Respuesta>
 */
class RespuestaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "palabras_correctas" => $this->faker->word(),
            "min_correctas" => $this->faker->numberBetween(1, 7),
            "palabras_incorrectas" => $this->faker->word(),
            "max_incorrectas" => $this->faker->numberBetween(1, 3),
        ];
    }
}
