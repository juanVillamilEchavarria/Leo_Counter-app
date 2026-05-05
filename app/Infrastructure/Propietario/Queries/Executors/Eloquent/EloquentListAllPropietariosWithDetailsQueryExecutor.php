<?php

namespace App\Infrastructure\Propietario\Queries\Executors\Eloquent;

use App\Application\Propietario\Contracts\Queries\Executors\PropietarioQueryExecutorContract;
use App\Application\Propietario\Contracts\Queries\ListPropietariosQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\Propietario\Propietario;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use App\Application\Propietario\DTOs\PropietarioWithDetailsListDTO;

/**
 * QueryExecutor Eloquent para listar todos los propietarios con detalles.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Propietario\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListAllPropietariosWithDetailsQueryExecutor implements PropietarioQueryExecutorContract
{
    public function execute(ListPropietariosQueryContract $query): CollectionContract
    {
         $propietarios = Propietario::withCount('cuentas')->get();

        $dtos = $propietarios->map(function ($propietario) {
            return new PropietarioWithDetailsListDTO(
                id: $propietario->id,
                nombre: $propietario->nombre,
                apellido: $propietario->apellido,
                email: $propietario->email,
                telefono: $propietario->telefono,
                noCuentas: $propietario->cuentas_count,
            );
        });

        return new LaravelCollection($dtos);
    }
}
