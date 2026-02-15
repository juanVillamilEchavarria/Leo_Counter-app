<?php

namespace App\Domains\Movimiento\DTOs;
use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Http\UploadedFile;

abstract class MovimientoDTO extends DTO{
    public function __construct(
        public string $nombre,
        public int $cuenta_id,
        public int $categoria_id,
        public int $tipo_movimiento_id,
        public float $monto,
        public ?string $descripcion = null,
        public ?int $movimiento_pendiente_id = null,
         public readonly ?array $comprobantes = null
    )
    {
    }

    public function newComprobantes (){
        return collect($this->comprobantes)->filter(fn($comprobante)=> $comprobante instanceof UploadedFile)->all();
    }
}