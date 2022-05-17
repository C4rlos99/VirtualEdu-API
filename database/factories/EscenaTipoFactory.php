<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EscenaTipo>
 */
class EscenaTipoFactory extends Factory
{
    public function definition()
    {
        return [
            "nombre" => $this->faker->word(),
        ];
    }
}
