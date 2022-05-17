<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
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
