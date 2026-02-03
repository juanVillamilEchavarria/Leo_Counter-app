<?php

namespace App\Domains\MovimientoPendiente\Enums;
enum EstadosMovimientoPendiente: string{
    case PENDIENTE = 'pendiente';
    case REALIZADO = 'realizado';
    case VENCIDO = 'vencido';
}