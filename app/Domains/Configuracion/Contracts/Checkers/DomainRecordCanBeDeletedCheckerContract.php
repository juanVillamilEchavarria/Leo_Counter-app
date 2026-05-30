<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Configuracion\Contracts\Checkers;

use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Contrato de verificacion de si un registro puede ser eliminado.
 * Cada dominio que tenga soft delete debe implementar una clase en infrastructura que implemente esta interfaz.
 * es usada en los soft delete managers, en cada una de las estrategias, se inyecta este contrato, que su implementacion real debe ser pasada mediante el binding en el service provider
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Configuracion\Contracts\Checkers
 * @since 1.0.0
 * @version 1.0.0
 */
interface DomainRecordCanBeDeletedCheckerContract
{
    /**
     * Verifica si un registro puede ser eliminado.
     * @param AggregateModelIdContract $id
     * @return bool
     */
    public function canBeDeleted(AggregateModelIdContract $id): bool;

}
