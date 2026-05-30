<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
