<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "nombre" => $this->faker->word(),
            "apellidos" => $this->faker->word(),
            "correo" => $this->faker->email(),
            "clave" => $this->faker->password(8, 8),
            "password" => $this->faker->password(4, 12),
        ];
    }
}
