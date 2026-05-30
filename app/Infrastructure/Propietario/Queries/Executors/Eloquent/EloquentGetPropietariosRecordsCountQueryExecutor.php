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
use App\Models\Propietario\Propietario;
use App\Application\Propietario\Contracts\Queries\Executors\GetPropietarioRecordsCountQueryExecutorContract;
/**
 * QueryExecutor Eloquent para obtener el conteo de propietarios.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Propietario\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentGetPropietariosRecordsCountQueryExecutor implements GetPropietarioRecordsCountQueryExecutorContract
{
    public function execute(): int
    {
        return Propietario::count();
    }
}
