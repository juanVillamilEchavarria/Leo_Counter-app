<?php
namespace App\Domains\ArchivoMovimiento\Actions;

use App\Models\ArchivoMovimiento\ArchivoMovimiento;

class GetArchivoMovimientoAction {
    public function getAll(){
        return ArchivoMovimiento::all();
    }

    public function getAllByMovimientoId(int $movimiento_id){
        return ArchivoMovimiento::where('movimiento_id', $movimiento_id)->get();
    }
}