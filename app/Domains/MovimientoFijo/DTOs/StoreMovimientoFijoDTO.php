<?php

namespace App\Domains\MovimientoFijo\DTOs;

use Illuminate\Database\Eloquent\Collection;

class StoreMovimientoFijoDTO{
    public function __construct(
        public ?int $cuenta_id,
        public ?int $categoria_id,
        public ?int $tipo_movimiento_id,
        public ?int $frecuencia_movimiento_id,
        public ?string $nombre,
        public ?string $descripcion,
        public ?float $monto,
        public ?string $fecha_proximo,
        public ?string $url_pago,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'cuenta_id' => $this->cuenta_id,
            'categoria_id' => $this->categoria_id,
            'tipo_movimiento_id' => $this->tipo_movimiento_id,
            'frecuencia_movimiento_id' => $this->frecuencia_movimiento_id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'monto' => $this->monto,
            'fecha_proximo' => $this->fecha_proximo,
            'url_pago' => $this->url_pago,
            'active' => true,
            'registrar_automatico' => false
        ];
    }
}