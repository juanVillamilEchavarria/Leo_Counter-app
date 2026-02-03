<?php

namespace App\Domains\ArchivoMovimiento\Actions;

use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use App\Domains\ArchivoMovimiento\DTOs\StoreArchivoMovimientoDTO;

class StoreArchivoMovimientoAction {

    public function store(StoreArchivoMovimientoDTO $storeArchivoMovimientoDTO): ArchivoMovimiento {
        return ArchivoMovimiento::create($storeArchivoMovimientoDTO->toArray());
    }
}