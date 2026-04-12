<?php
namespace App\Application\Reporte\DTOs\IngresosVsGastos;

use App\Application\Reporte\DTOs\Financial\FinancialPeriodDTO;
use App\Shared\Abstracts\DTOs\DTO;
use App\Application\Reporte\DTOs\Promedio\PromedioDTO;

final class IngresosVsGastosDTO extends DTO{
    /**
     * @param array<int, FinancialPeriodDTO> $data
     */
    public function __construct(
        public readonly array $data,
        public readonly PromedioDTO $promedios
    )
    {
    }
}
