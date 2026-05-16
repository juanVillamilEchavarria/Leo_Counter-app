<?php

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
