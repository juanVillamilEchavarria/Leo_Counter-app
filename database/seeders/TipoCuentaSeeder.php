<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoCuenta\TipoCuenta;

class TipoCuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposCuentas = [
            ['tipo_cuenta' => 'Tarjeta Debito'],
            ['tipo_cuenta' => 'Tarjeta Credito'],
            ['tipo_cuenta' => 'Billetera Digital'],
            ['tipo_cuenta' => 'Cuenta Corriente'],
            ['tipo_cuenta' => 'Efectivo']
        ];
        foreach ($tiposCuentas as $tipoCuenta) {
            TipoCuenta::firstOrCreate($tipoCuenta);
        }
    }
}
