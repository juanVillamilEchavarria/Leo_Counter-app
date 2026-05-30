<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\TipoMovimiento\Enums;

enum TipoMovimientoEnum: int
{
    case INGRESO = 1;
    case GASTO = 2;
   public static function try(int $value):self{
       return match($value){
           1 => self::INGRESO,
           2 => self::GASTO,
           default => throw new \LogicException('Tipo de movimiento no valido')
       };
   }
}
