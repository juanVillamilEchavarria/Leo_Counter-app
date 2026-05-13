<?php

namespace App\Application\ArchivoMovimiento\Commands;

use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Shared\Application\Contracts\ValueObjects\UploadedFileContract;

/**
 * Comando para el almacenamiento de un archivo movimiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StoreArchivoMovimientoCommand
{
    public function __construct(
        public MovimientoId $movimiento_id,
        public UploadedFileContract $file,
        public FilePath $file_path,
    )
    {
    }

}
