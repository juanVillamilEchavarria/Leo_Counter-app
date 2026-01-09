<?php

namespace App\Domains\Cuenta\DTOs;

use Illuminate\Database\Eloquent\Collection;
class CuentaFormOptionsDTO{
    public function __construct(
        public Collection $propietarios,
        public Collection $tipo_cuentas
    ){}
}