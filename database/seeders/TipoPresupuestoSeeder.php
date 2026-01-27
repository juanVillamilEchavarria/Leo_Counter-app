<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoPresupuesto\TipoPresupuesto;

class TipoPresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos =[
            ['tipo_presupuesto'=> 'Operativo'],
            ['tipo_presupuesto'=> 'Planificado'],
            ['tipo_presupuesto'=> 'Ahorro']

        ];
        foreach($tipos as $tipo){
            TipoPresupuesto::firstOrCreate($tipo);
        }
    }
}
