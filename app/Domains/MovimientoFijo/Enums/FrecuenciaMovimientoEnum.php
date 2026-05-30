<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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

    public static function try(int $value): self{
        return match($value){
            1=> self::DIARIO,
            2=> self::SEMANAL,
            3=> self::QUINCENAL,
            4=> self::MENSUAL,
            5=> self::BIMESTRAL,
            6=> self::TRIMESTRAL,
            7=> self::SEMESTRAL,
            8=> self::ANUAL,
            default => throw new \InvalidArgumentException("Valor no valido para FrecuenciaMovimientoEnum: $value")
        };
    }

}
