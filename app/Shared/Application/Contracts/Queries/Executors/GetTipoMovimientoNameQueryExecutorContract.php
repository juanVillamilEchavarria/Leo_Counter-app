<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Application\Contracts\Queries\Executors;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

/**
 * Contrato que define el ejecutor de query que debe traer el nombre de un tipo de movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface GetTipoMovimientoNameQueryExecutorContract
{
    /**Obtiene el nombre del tipo de movimiento
     * @param TipoMovimientoEnum $tipoMovimiento - tipo de movimiento a encontrar
     * @return string
     */
    public function getName(TipoMovimientoEnum $tipoMovimiento): string;

}
