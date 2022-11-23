<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Libro>
 */
class LibroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre'=> fake()->unique()->name(),
            'autor'=> fake()->name(),
            'anio'=>fake()->numberBetween(1000,2022),
            'sinopsis'=>fake()->paragraph(),
            'calificacion'=>fake()->numberBetween(1,10)
        ];
    }
}
