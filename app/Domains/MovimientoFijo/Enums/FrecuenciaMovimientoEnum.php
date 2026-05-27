<?php

namespace App\Domains\MovimientoFijo\Enums;

/**
 * Enumeracion que define las posibles frecuencias de un movimiento fijo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoFijo\Enums
 * @since 1.0.0
 * @version 1.0.0
 */
enum FrecuenciaMovimientoEnum : int
{
    CASE DIARIO = 1;
    CASE SEMANAL = 2;
    CASE QUINCENAL = 3;
    CASE MENSUAL = 4;
    CASE BIMESTRAL = 5;
    CASE TRIMESTRAL = 6;
    CASE SEMESTRAL = 7;
    CASE ANUAL = 8;

}
