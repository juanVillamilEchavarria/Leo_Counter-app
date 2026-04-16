<?php
namespace App\Application\Reporte\DTOs\Movimientos\KPI;
use App\Shared\Abstracts\DTOs\DTO;

class VariationsKPIDTO extends DTO{
    public function __construct(
        public ?float $ingresos,
        public ?float $gastos,
        public ?float $balance_neto,
        public ?float $movimientos
    )
    {
    }
}
