<?php

namespace App\Application\Cuenta\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Database\Eloquent\Collection;
class CuentaFormOptionsDTO extends DTO{
    public function __construct(
        public Collection $propietarios,
        public Collection $tipo_cuentas
    ){}
}