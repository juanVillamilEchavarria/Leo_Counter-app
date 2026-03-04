<?php
namespace App\Domains\Reporte\DTOs;


use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Carbon;

class ReporteQueryDTO extends DTO
{
    public function __construct(
       public Carbon | string | null $startDate = null,
        public Carbon | string | null $endDate = null
    )
    {
        $this->startDate = is_null($this->startDate) ?
                Carbon::now()->subMonths(6) : // por default 6 meses
                    (is_string($this->startDate) ? 
                    Carbon::parse($this->startDate) : 
                    $this->startDate);
                    
        $this->endDate = is_null($this->endDate) ?
                Carbon::now():
                    ( is_string($this->endDate) ?
                    Carbon::parse($this->endDate) :
                    $this->endDate);
        
    }

}