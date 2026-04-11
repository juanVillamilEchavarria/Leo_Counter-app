<?php
namespace App\Application\Reporte\DTOs\IngresosVsGastos;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Collection;
use App\Application\Reporte\DTOs\Promedio\PromedioDTO;

class IngresosVsGastosDTO extends DTO{
    public function __construct(
        public Collection $data,
        public PromedioDTO $promedios
    )
    {
    }
}