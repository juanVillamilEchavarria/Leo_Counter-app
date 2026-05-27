<?php

namespace App\Domains\MovimientoPendiente\Enums;
enum EstadosMovimientoPendiente: string{
    case PENDIENTE = 'pendiente';
    case REALIZADO = 'realizado';
    case VENCIDO = 'vencido';

    public static function try(string $case): self{
        return match($case){
            'pendiente'=>self::PENDIENTE,
            'realizado'=>self::REALIZADO,
            'vencido'=> self::VENCIDO,
            default => throw new \LogicException('estado de movimiento  no valido')
        };
    }
}
