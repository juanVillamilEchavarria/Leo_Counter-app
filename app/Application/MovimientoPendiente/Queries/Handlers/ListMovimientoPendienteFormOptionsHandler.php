<?php

namespace App\Application\MovimientoPendiente\Queries\Handlers;

use App\Application\MovimientoPendiente\DTOs\MovimientoPendienteFormOptionsDTO;
use App\Application\MovimientoPendiente\Queries\ListMovimientoPendienteFormOptionsQuery;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCategoriaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCuentaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListTipoMovimientoForFormContract;

/**
 * Handler encargado de componer las opciones de formulario de MovimientoPendiente.
 * Usa contratos compartidos de opciones de formulario y no depende de read repositories
 * ni servicios de consulta obsoletos. Compone categorias, cuentas y tipos de movimiento.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListMovimientoPendienteFormOptionsHandler
{
    public function __construct(
        private ListCategoriaForFormContract $categoriaForForm,
        private ListCuentaForFormContract $cuentaForForm,
        private ListTipoMovimientoForFormContract $tipoMovimientoForForm,
    ) {
    }

    public function __invoke(ListMovimientoPendienteFormOptionsQuery $query): MovimientoPendienteFormOptionsDTO
    {
        return new MovimientoPendienteFormOptionsDTO(
            categorias: $this->categoriaForForm->execute(),
            tipos_movimientos: $this->tipoMovimientoForForm->execute(),
            cuentas: $this->cuentaForForm->execute(),
        );
    }
}
