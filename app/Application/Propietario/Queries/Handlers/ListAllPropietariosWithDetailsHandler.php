<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Propietario\Queries\Handlers;

use App\Application\Propietario\Queries\ListAllPropietariosWithDetailsQuery;
use App\Application\Propietario\Contracts\Queries\Executors\PropietarioQueryExecutorContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler que maneja la consulta de listar todos los propietarios con detalles.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllPropietariosWithDetailsHandler
{
    public function __construct(
        private PropietarioQueryExecutorContract $executor,
    ) {}

    public function __invoke(ListAllPropietariosWithDetailsQuery $query): CollectionContract
    {
        return $this->executor->execute($query);
    }
}
