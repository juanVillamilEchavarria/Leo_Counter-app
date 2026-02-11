<?php

namespace App\Domains\Movimiento\Enums;
enum MoneyFlowEnum : string {
    case APPLY = 'apply';
    case REVERT = 'revert';
}