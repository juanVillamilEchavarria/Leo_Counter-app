<?php

namespace App\Application\ArchivoMovimiento\DTOs;
use App\Shared\Abstracts\DTOs\DTO;

class UpdateArchivoMovimientoLocationDTO extends DTO  {
   public function __construct(
        public string $path,
        public string $disk = 'movimientos',
        public string $extension = 'pdf',
        public string $mime_type ='application/pdf',
        
    ){}
}