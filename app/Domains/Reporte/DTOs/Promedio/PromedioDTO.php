<?php
namespace App\Domains\Reporte\DTOs\Promedio;

use App\Shared\Abstracts\DTOs\DTO;

class PromedioDTO extends DTO{
    public function __construct(
        public float $ingresos,
        public float $gastos
    )
    {
    }
}