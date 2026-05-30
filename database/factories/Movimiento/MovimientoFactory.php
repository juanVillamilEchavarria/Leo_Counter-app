<?php

namespace Database\Factories\Movimiento;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class MovimientoFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->sentence(3),
            'cuenta_id'=> 1,
            'categoria_id' => 1,
            'tipo_movimiento_id' => fake()->randomElement([1, 2]), // Asumiendo que 1 = Ingreso, 2 = Gasto
            'monto' => fake()->randomFloat(2, 0, 1000),
            'fecha' => fake()->date(),
            'descripcion' => fake()->paragraph(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
