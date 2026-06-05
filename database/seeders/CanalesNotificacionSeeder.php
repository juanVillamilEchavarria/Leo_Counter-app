<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notificacion\CanalNotificacion;
use Ramsey\Uuid\Uuid;

class CanalesNotificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CanalNotificacion::firstOrCreate([
            'id'=> Uuid::uuid7()->toString(),
            'nombre' => 'Email',
<<<<<<< HEAD
            'active'=>false
=======
            'active'=>true
>>>>>>> 23def1b7b9d919ef710829c8b7a5a63623b7ed7b
        ]);
    }
}
