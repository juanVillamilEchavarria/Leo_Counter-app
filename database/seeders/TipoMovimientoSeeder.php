<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoMovimiento\TipoMovimiento;

class TipoMovimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $tipos = [
        'Ingreso',
        'Gasto',
       ];
         foreach($tipos as $tipo){
          TipoMovimiento::firstOrCreate(['tipo_movimiento' => $tipo]);
         }
    }
}
