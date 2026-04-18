<?php
namespace App\Application\Reporte\Queries\Movimientos\Comparatives;

use App\Domains\Reporte\ValueObjects\Financial\IncomeExpensePeriodVO;
use App\Shared\Abstracts\DTOs\DTO;
use App\Application\Reporte\Queries\Movimientos\Averages\PromedioDTO;
use App\Shared\Domain\Contracts\CollectionContract;

final class IngresosVsGastosDTO extends DTO{
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
