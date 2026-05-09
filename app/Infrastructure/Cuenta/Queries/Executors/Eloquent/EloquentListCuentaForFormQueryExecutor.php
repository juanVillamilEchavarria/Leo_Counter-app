<?php

namespace App\Infrastructure\Cuenta\Queries\Executors\Eloquent;

use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCuentaForFormContract;

use App\Models\Cuenta\Cuenta;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use Override;

/**
 * Clase que se encarga de traer todas las cuentas para mostrar como opcion de un formulario.
 * Trae las cuentas solo con el id y el nombre.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Cuenta\Queries\Executors\Eloquent
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class EloquentListCuentaForFormQueryExecutor implements ListCuentaForFormContract{
    #[Override]
    public function execute(): CollectionContract
    {
        return LaravelCollection::make( Cuenta::where('active', true)->get(['id', 'nombre']));
    }
}
