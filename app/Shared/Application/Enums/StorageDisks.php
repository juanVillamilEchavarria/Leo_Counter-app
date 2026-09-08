<?php

namespace App\Shared\Application\Enums;

use App\Domains\ArchivoMovimiento\Enums\ArchivoMovimientoDiskEnum;

enum StorageDisks: string{
    case ARCHIVO_MOVIMIENTO = ArchivoMovimientoDiskEnum::DISK->value;
    case LOCAL = 'local';
}