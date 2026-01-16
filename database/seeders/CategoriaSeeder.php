<?php

namespace Database\Seeders;

use App\Models\Categoria\Categoria;
use App\Models\TipoMovimiento\TipoMovimiento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingresoId = TipoMovimiento::where('tipo_movimiento', 'Ingreso')->firstOrFail()->id;
        $gastoId = TipoMovimiento::where('tipo_movimiento', 'Gasto')->firstOrFail()->id; 
        $categorias =[
            //ingresos
            [
                'nombre'=>'Ingresos Laborales',
                'tipo_movimiento_id'=>$ingresoId,
                'es_fijo'=>true,
                'descripcion'=>'Salario y otros ingresos fijos por trabajo',
                'is_system'=>true
            ],
            [
                'nombre'=> 'Inversiones',
                'tipo_movimiento_id'=>$ingresoId,
                'es_fijo'=>false,
                'descripcion'=>'Ganancias provenientes de inversiones financieras',
                'is_system'=>true
            ],
            [
                'nombre'=> 'Otros Ingresos',
                'tipo_movimiento_id'=>$ingresoId,
                'es_fijo'=>false,
                'descripcion'=>'Cualquier otro ingreso no recurrente (regalos, ventas ocasionales, etc.)',
                'is_system'=>true
            ],

            //gastos
            [
                'nombre'=> 'Vivienda',
                'tipo_movimiento_id'=>$gastoId,
                'es_fijo'=>true,
                'descripcion'=>'Gastos relacionados con la vivienda, como alquiler o hipoteca',
                'is_system'=>true
            ],
            [
                'nombre'=> 'Servicios Publicos',
                'tipo_movimiento_id'=>$gastoId,
                'es_fijo'=>true,
                'descripcion'=>'Gastos en servicios como agua, luz, gas, internet, etc.',
                'is_system'=>true

            ],
            [
                'nombre'=> 'Transporte',
                'tipo_movimiento_id'=>$gastoId,
                'es_fijo'=>false,
                'descripcion'=>'Gastos en transporte publico, gasolina, mantenimiento del vehiculo, etc.',
                'is_system'=>true

            ],
            [
                'nombre'=> 'Alimentacion',
                'tipo_movimiento_id'=>$gastoId,
                'es_fijo'=>false,
                'descripcion'=>'Gastos relacionados con la alimentacion',
                'is_system'=>true
            ],
            [
                'nombre'=> 'Salud',
                'tipo_movimiento_id'=>$gastoId,
                'es_fijo'=>false,
                'descripcion'=>'Gastos medicos, seguros de salud, medicamentos, etc.',
                'is_system'=>true
            ],
            [
                'nombre'=> 'Educacion',
                'tipo_movimiento_id'=>$gastoId,
                'es_fijo'=>false,
                'descripcion'=>'Gastos en matrículas, libros, cursos, etc.',
                'is_system'=>true

            ],
            [
                'nombre'=> 'Hogar y Mantenimiento',
                'tipo_movimiento_id'=>$gastoId,
                'es_fijo'=>false,
                'descripcion'=>'Gastos en reparaciones, mantenimiento, articulos de limpieza y mejoras del hogar.',
                'is_system'=>true

            ],
            [
                'nombre'=> 'Entretenimiento y Ocio',
                'tipo_movimiento_id'=>$gastoId,
                'es_fijo'=>false,
                'descripcion'=>'Gastos en actividades recreativas, suscripciones, salidas, etc.',
                'is_system'=>true
            ],
            [
                'nombre'=> 'Ahorro y Fondos de Emergencia',
                'tipo_movimiento_id'=>$gastoId,
                'es_fijo'=>true,
                'descripcion'=>'Dinero destinado a ahorros o fondos de emergencia',
                'is_system'=>true
            ],
            [
                'nombre'=> 'Otros Gastos',
                'tipo_movimiento_id'=>$gastoId,
                'es_fijo'=>false,
                'descripcion'=>'Cualquier otro gasto no recurrente (regalos, compras ocasionales, etc.)',
                'is_system'=>true
            ]


        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate($categoria);
        }
    }
}
