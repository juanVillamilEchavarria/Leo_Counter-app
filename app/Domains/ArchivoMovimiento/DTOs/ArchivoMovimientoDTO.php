<?php

namespace App\Domains\ArchivoMovimiento\DTOs;

use App\Shared\Abstracts\DTOs\DTO;

abstract class ArchivoMovimientoDTO extends DTO{
    public function __construct(
        public int $movimiento_id,
        public string $nombre_original,
        public string $nombre_guardado,
        public string $path,
        public int $tamano_bytes,
        public ?string $notas = null,
        public string $disk = 'movimientos',
        public string $extension = 'pdf',
        public string $mime_type ='application/pdf',
        
    ){}
}