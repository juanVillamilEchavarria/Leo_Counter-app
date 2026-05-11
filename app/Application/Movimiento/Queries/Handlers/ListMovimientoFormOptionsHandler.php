<?php

namespace App\Application\Movimiento\Queries\Handlers;

use App\Application\Movimiento\Queries\ListMovimientoFormOptionsQuery;
use App\Application\Movimiento\DTOs\MovimientoFormOptionsDTO;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCategoriaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCuentaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListTipoMovimientoForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListFrecuenciaMovimientoForFormContract;

/**
 * Handler encargado de devolver las opciones necesarias para los formularios de movimientos.
 * Reutiliza los executors compartidos de opciones de formulario.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListMovimientoFormOptionsHandler
{
    public function __construct(
        private ListCategoriaForFormContract $categoriaForForm,
        private ListCuentaForFormContract $cuentaForForm,
        private ListTipoMovimientoForFormContract $tipoMovimientoForForm,
        private ListFrecuenciaMovimientoForFormContract $frecuenciaMovimientoForForm,
    ){}

    public function __invoke(ListMovimientoFormOptionsQuery $query): MovimientoFormOptionsDTO
    {
        return new MovimientoFormOptionsDTO(
            categorias: $this->categoriaForForm->execute(),
            tipos_movimientos: $this->tipoMovimientoForForm->execute(),
            frecuencias_movimientos: $this->frecuenciaMovimientoForForm->execute(),
            cuentas: $this->cuentaForForm->execute(),
        );
    }
}
