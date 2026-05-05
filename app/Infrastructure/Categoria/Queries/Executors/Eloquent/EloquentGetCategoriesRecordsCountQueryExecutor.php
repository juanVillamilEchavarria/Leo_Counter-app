<?php

namespace App\Infrastructure\Categoria\Queries\Executors\Eloquent;

use App\Application\Categoria\Contracts\Queries\Executors\GetCategoriaRecordsCountQueryExecutorContract;
use App\Models\Categoria\Categoria;

/**
 * Ejecutor encargado de obtener el conteo total de registros de categorías utilizando Eloquent ORM.
 * Este executor implementa un contrato específico para el caso de uso de conteo de registros de categorías.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Categoria\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentGetCategoriesRecordsCountQueryExecutor implements GetCategoriaRecordsCountQueryExecutorContract
{
    public function execute(): int
    {
        return Categoria::count();
    }
}
