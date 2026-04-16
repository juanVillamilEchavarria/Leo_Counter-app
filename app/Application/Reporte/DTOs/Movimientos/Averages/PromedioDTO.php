<?php
namespace App\Application\Reporte\DTOs\Movimientos\Averages;

use App\Shared\Abstracts\DTOs\DTO;

class PromedioDTO extends DTO{
    public function __construct(
        public ?float $ingresos_por_periodo,
        public ?float $gastos_por_periodo,
        public ?float $ingresos_por_movimiento,
        public ?float $gastos_por_movimiento
    )
    {
    }
}