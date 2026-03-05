<?php

namespace App\Domains\Movimiento\DTOs;

use App\Domains\Movimiento\DTOs\MovimientoDTO;

class UpdateMovimientoDTO extends MovimientoDTO
{
  public readonly ?array $comprobantes_delete_ids;
  public readonly ?array $comprobantes_existing;
  public function __construct(string $nombre, int $cuenta_id, int $categoria_id, int $tipo_movimiento_id, float $monto, ?string $descripcion = null, ?int $movimiento_pendiente_id = null, ?array $comprobantes = null, ?array $comprobantes_delete_ids = null, ?array $comprobantes_existing = null)
  {
    $this->comprobantes_delete_ids = $comprobantes_delete_ids;
    $this->comprobantes_existing = $comprobantes_existing;
     parent::__construct($nombre, $cuenta_id, $categoria_id, $tipo_movimiento_id, $monto, $descripcion, $movimiento_pendiente_id, $comprobantes);
  }
 protected array $except = [
   'comprobantes',
   'comprobantes_delete_ids'
 ];
}