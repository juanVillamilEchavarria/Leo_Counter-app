<?php
namespace App\Domains\Cuenta\DTOs;

use App\Domains\Cuenta\DTOs\CuentaDTO;

class StoreCuentaDTO extends CuentaDTO
{

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'saldo_actual' => $this->saldo_inicial
        ]);
    }


}