<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Propietario\Queries\Executors\Eloquent;

use App\Application\Propietario\Contracts\Queries\Executors\PropietarioForShowQueryExecutorContract;
use App\Application\Propietario\DTOs\PropietarioShowDTO;
use App\Domains\Propietario\Exceptions\CannotFindPropietarioException;
use App\Models\Propietario\Propietario;

/**
 * Ejecutor de consulta para obtener un propietario con sus detalles completos usando Eloquent ORM.
 * @author JuanVillamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentPropietarioForShowQueryExecutor implements PropietarioForShowQueryExecutorContract{

    public function execute(string $id): PropietarioShowDTO
    {
        $record = Propietario::find($id);
        if (!$record) {
            throw new CannotFindPropietarioException();
        }

        $cuentas = $record->cuentas;
        return new PropietarioShowDTO((string) $record->id, $record->nombre, $record->apellido, $record->telefono, $record->email, $cuentas->toArray());
    }
}
