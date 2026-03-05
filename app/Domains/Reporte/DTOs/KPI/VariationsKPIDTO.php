<?php
namespace App\Domains\Reporte\DTOs\KPI;
use App\Shared\Abstracts\DTOs\DTO;

class VariationsKPIDTO extends DTO{
    public function __construct(
        public ?float $ingresos,
        public ?float $gastos,
        public ?float $balance_neto,
        public ?int $movimientos
    )
    {
    }
}