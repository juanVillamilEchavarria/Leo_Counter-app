<?php

namespace Database\Seeders;

use App\Models\Propietario\Propietario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class PropietarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Propietario::factory()
            ->count(10)
            ->sequence(fn ($sequence) => ['id' => Uuid::uuid7()->toString()])
            ->create();
    }
}
