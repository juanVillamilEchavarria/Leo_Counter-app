<?php

namespace App\Application\MovimientoFijo\Queries\Handlers;

use App\Application\MovimientoFijo\DTOs\MovimientoFijoFormOptionsDTO;
use App\Application\MovimientoFijo\Queries\ListMovimientoFijoFormOptionsQuery;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCategoriaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCuentaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListFrecuenciaMovimientoForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListTipoMovimientoForFormContract;

/**
 * Handler encargado de componer las opciones de formulario de MovimientoFijo.
 * Usa contratos compartidos de opciones y no depende de read repositories ni servicios de consulta obsoletos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListMovimientoFijoFormOptionsHandler
{
    public function __construct(
        private ListCategoriaForFormContract $categoriaForForm,
        private ListCuentaForFormContract $cuentaForForm,
        private ListTipoMovimientoForFormContract $tipoMovimientoForForm,
        private ListFrecuenciaMovimientoForFormContract $frecuenciaMovimientoForForm,
    ) {
    }

    public function __invoke(ListMovimientoFijoFormOptionsQuery $query): MovimientoFijoFormOptionsDTO
    {
        return new MovimientoFijoFormOptionsDTO(
            categorias: $this->categoriaForForm->execute(),
            tipos_movimientos: $this->tipoMovimientoForForm->execute(),
            frecuencias_movimientos: $this->frecuenciaMovimientoForForm->execute(),
            cuentas: $this->cuentaForForm->execute(),
        );
    }
}
