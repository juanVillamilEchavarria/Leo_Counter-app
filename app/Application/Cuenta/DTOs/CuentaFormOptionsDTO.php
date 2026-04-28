<?php

namespace App\Application\Cuenta\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use App\Shared\Domain\Contracts\CollectionContract;
class CuentaFormOptionsDTO extends DTO{
    public function __construct(
        public  CollectionContract $propietarios,
        public CollectionContract $tipo_cuentas
    ){}
}