<?php
namespace App\Application\Reporte\DTOs\Movimientos\Comparatives;

use App\Domains\Reporte\ValueObjects\Financial\IncomeExpensePeriodVO;
use App\Application\Reporte\DTOs\Movimientos\Averages\PromedioDTO;
use App\Shared\Domain\Contracts\CollectionContract;

final readonly class IngresosVsGastosDTO {
    /**
     * @param CollectionContract<IncomeExpensePeriodVO> $data
     */
    public function __construct(
        public readonly CollectionContract $data,
        public readonly PromedioDTO $promedios
    )
    {
    }
}
