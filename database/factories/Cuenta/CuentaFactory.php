<?php

    namespace Database\Factories\Cuenta;

use App\Models\Propietario\Propietario;
use App\Models\TipoCuenta\TipoCuenta;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CuentaFactory extends Factory
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
            'saldo_inicial' => fake()->randomFloat(2, 0, 10000),
            'saldo_actual' => fake()->randomFloat(2, 0, 10000),
            'tipo_cuenta_id' => TipoCuenta::factory(),
            'propietario_id' => Propietario::factory(),
            'notas'=> fake()->paragraph(),
            'active'=> true,
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
