<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'id'=>Uuid::uuid7()->toString(),
            'name' => 'Juan',
            'email' => 'juan@example.com',
            'password'=> Hash::make('password')
        ]);
        $this->call([
            PropietarioSeeder::class,
            FrecuenciaMovimientoSeeder::class,
            TipoCuentaSeeder::class,
            TipoMovimientoSeeder::class,
            CategoriaSeeder::class
        ]);
    }
}
