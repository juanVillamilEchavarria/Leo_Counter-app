<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Domain\Contracts;

use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * contrato de repositorio base para evitar reescribir cada vez el mismo contrato en cada dominio (DRY), Al igual que si se hace algun cambio a nivel de repositorio, simplemente se editaria este contrato, y no la cantidad de contratos que se esten usando.
 * Cada dominio debe implementar este contrato y agregar las operaciones permitidas.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoFijo\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface RepositoryContract
{
    /**
     * Persiste un modelo
     *
     * @param AggregateModelContract $model Agregado a persistir.
     * @return AggregateModelContract Agregado reconstituido desde persistencia.
     */
    public function store(AggregateModelContract $model): AggregateModelContract;

    /**
     * Actualiza un modelo
     *
     * @param AggregateModelContract $model Agregado con los nuevos datos.
     * @return bool Resultado de la operacion.
     */
    public function update(AggregateModelContract $model): bool;

    /**
     * Elimina un modelo por su identidad
     *
     * @param AggregateModelIdContract $id identidad del modelo
     * @return bool Resultado de la operacion.
     */
    public function destroy(AggregateModelIdContract $id): bool;


    /**
     * Busca un modelo por identidad y lo reconstituye como agregado.
     *
     * @param AggregateModelIdContract $id Identidad del modelo
     * @return AggregateModelContract|null Agregado encontrado o null.
     */
    public function findById(AggregateModelIdContract $id): ?AggregateModelContract;
}
