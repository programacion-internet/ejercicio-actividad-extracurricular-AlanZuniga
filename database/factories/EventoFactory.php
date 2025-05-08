<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generar una fecha aleatoria entre hoy y dentro de 30 días
        $fechaEvento = $this->faker->dateTimeBetween('now', '+30 days');
        
        return [
            'nombre' => $this->faker->name(),
            'descripcion' => $this->faker->paragraph(1),
            'fecha' => $fechaEvento,
        ];
    }
}
