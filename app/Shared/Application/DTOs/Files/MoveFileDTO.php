<?php

namespace App\Shared\Application\DTOs\Files;


use App\Domains\ArchivoMovimiento\Enums\ArchivoMovimientoDiskEnum;

/**
 * DTO encargado de transportar los parametros necesarios para mover un archivo en el almacenamiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MoveFileDTO{
    public function __construct(
        public ArchivoMovimientoDiskEnum $disk,
        public string $oldPath,
        public string $newPath,
    )
    {
    }

}
