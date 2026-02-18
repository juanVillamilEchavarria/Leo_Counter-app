<?php

namespace App\Shared\DTOs\Files;

use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use App\Shared\Abstracts\DTOs\DTO;

class MoveFileDTO extends DTO{
    public function __construct(
        public string $disk,
        public string $oldPath,
        public string $newPath,
    )
    {
    }

    public static function fromArchivoMovimientoAndNewPath (ArchivoMovimiento $file, string $newPath){
        return new self(
            disk: $file->disk,
            oldPath: $file->path . $file->nombre_guardado,
            newPath: $newPath . $file->nombre_guardado
        );
    }
}