<?php
namespace App\Domains\Reporte\DTOs\Promedio;

use App\Shared\Abstracts\DTOs\DTO;

class PromedioDTO extends DTO{
    public function __construct(
        public float $ingresos_por_periodo,
        public float $gastos_por_periodo,
        public float $ingresos_por_movimiento,
        public float $gastos_por_movimiento
    )
    {
    }
}