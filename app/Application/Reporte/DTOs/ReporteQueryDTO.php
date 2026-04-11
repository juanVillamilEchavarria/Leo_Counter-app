<?php
namespace App\Application\Reporte\DTOs;


use App\Shared\Abstracts\DTOs\DTO;
use App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract;
use App\Domains\Reporte\ValueObjects\DateRange;
use App\Shared\DTOs\Querys\IdsDTO;

class ReporteQueryDTO extends DTO
{
    public function __construct(
        public ReportGranularityStrategyContract $granularityStrategy,
         public DateRange $dateRange,
        public bool $only_categorias_fijas = false,
         public ?IdsDTO $categorias = null,
         public ?IdsDTO $cuentas = null,
  
    )
    {   
    }

}