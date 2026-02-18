<?php

namespace App\Domains\ArchivoMovimiento\Services;

use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;
use App\Models\Movimiento\Movimiento;
use Illuminate\Support\Carbon;

class FilePathBuilder {
    public function buildFromMovimiento(Movimiento $Movimiento, ?Carbon $date = null): FilePath {
        $date = $date ?? Carbon::now();
        return new FilePath(
            $date->year,
            $date->month,
            $Movimiento->tipo_movimiento->tipo_movimiento,
            $Movimiento->categoria->nombre,
        );
    }

    public function buildFromData(string $tipo_movimiento, string $categoria, ?Carbon $date= null): FilePath {
        $date = $date ?? Carbon::now();
        return new FilePath(
            $date->year,
            $date->month,
            $tipo_movimiento,
            $categoria
        );
     }

     public function buildWithCategoriaAndTipoMovimiento(Movimiento $movimiento, string $categoria, string $tipo_movimiento): FilePath{
        $basePath = $this->buildFromMovimiento($movimiento);
        return $basePath->withCategoriaAndTipoMovimiento($categoria, $tipo_movimiento);
     }

}