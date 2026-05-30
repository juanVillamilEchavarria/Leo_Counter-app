<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FrecuenciaMovimiento\FrecuenciaMovimiento;

class FrecuenciaMovimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $frecuencias = [
          'Diario',
          'Semanal',
          'Quincenal',
          'Mensual',
          'Bimestral',
          'Trimestral',
          'Semestral',
          'Anual',
          'Unica Vez (Recordatorio)'
         ];
            foreach($frecuencias as $frecuencia){
             FrecuenciaMovimiento::firstOrCreate(['frecuencia_movimiento' => $frecuencia]);
            }
    }
}
