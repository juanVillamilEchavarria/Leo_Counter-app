<?php
namespace App\Domains\Reporte\DTOs\IngresosVsGastos;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Collection;
use App\Domains\Reporte\DTOs\Promedio\PromedioDTO;

class IngresosVsGastosDTO extends DTO{
    public function __construct(
        public Collection $data,
        public PromedioDTO $promedios
    )
    {
    }
}