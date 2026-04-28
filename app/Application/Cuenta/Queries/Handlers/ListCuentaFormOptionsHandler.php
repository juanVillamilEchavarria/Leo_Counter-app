<?php

namespace App\Application\Cuenta\Queries\Handlers;

use App\Application\Cuenta\DTOs\CuentaFormOptionsDTO;
use App\Application\Cuenta\Contracts\Queries\Executors\FormOptions\ListTipoCuentaForFormContract;
use App\Application\Cuenta\Contracts\Queries\Executors\FormOptions\ListPropietarioForFormContract;
use App\Application\Cuenta\Contracts\Queries\ListCuentasQueryContract;

/**
 * Handler for getting form options for cuenta forms
 */
final readonly class ListCuentaFormOptionsHandler
{
    public function __construct(
        private ListPropietarioForFormContract $propietarioForForm,
        private ListTipoCuentaForFormContract $tipoCuentaForForm,
    ) {}

    public function __invoke( ListCuentasQueryContract $query ): CuentaFormOptionsDTO
    {
        return new CuentaFormOptionsDTO(
            propietarios: $this->propietarioForForm->execute(),
            tipo_cuentas: $this->tipoCuentaForForm->execute(),
        );
    }
}