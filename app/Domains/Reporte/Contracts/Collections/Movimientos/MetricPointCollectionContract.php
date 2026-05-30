<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Reporte\Contracts\Collections\Movimientos;
use App\Shared\Domain\Contracts\CollectionContract;
/**
 * Interface que representa una coleccion de puntos de datos metricos (fecha y valor) para reportes
 * Cada punto de dato debe ser una instancia de la clase MetricPointVO
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @see App\Domains\Reporte\ValueObjects\Common\MetricPointVO
 */
interface MetricPointCollectionContract{
    /**
     * Retorna el monto total de la coleccion
     * @return int
     */
    public function totalMonto(): int;
    /**
     * Retorna la cantidad de registros de la coleccion
     * @return int
     */
    public function totalRecords(): int;
}