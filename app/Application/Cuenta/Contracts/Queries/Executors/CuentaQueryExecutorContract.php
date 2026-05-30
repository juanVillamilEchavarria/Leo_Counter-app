<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Cuenta\Contracts\Queries\Executors;

use App\Application\Cuenta\Contracts\Queries\ListCuentasQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contract for Cuenta query executors
 */
interface CuentaQueryExecutorContract
{
    /**
     * Execute a Cuenta query
     * @param ListCuentasQueryContract $query
     * @return CollectionContract|int
     */
    public function execute(ListCuentasQueryContract $query): CollectionContract|int;
}