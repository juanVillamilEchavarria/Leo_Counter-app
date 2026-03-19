<?php
namespace App\Domains\Reporte\DTOs;


use App\Shared\Abstracts\DTOs\DTO;
use App\Domains\Reporte\Strategies\Contracts\ReportGranularityStrategyContract;
use App\Domains\Reporte\ValueObjects\DateRange;
use App\Shared\DTOs\Querys\IdsDTO;

class ReporteQueryDTO extends DTO
{
    public function __construct(
        public ReportGranularityStrategyContract $granularityStrategy,
         public DateRange $dateRange,
         public ?IdsDTO $categorias = null,
         public ?IdsDTO $cuentas = null
    )
    {   
    }

}