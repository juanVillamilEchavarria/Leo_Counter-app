<?php

namespace App\Application\ArchivoMovimiento\Builders;

use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;
use App\Models\Movimiento\Movimiento;
use Illuminate\Support\Carbon;

final readonly class FilePathBuilder {
    public static function buildFromNow(string $tipo_movimiento, string $categoria): FilePath {
        $date = new \DateTimeImmutable();
        return new FilePath(
            $date->format('Y'),
            $date->format('m'),
            $tipo_movimiento,
            $categoria
        );
     }

}
