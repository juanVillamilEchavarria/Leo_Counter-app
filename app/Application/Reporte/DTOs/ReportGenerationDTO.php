<?php
namespace App\Application\Reporte\DTOs;

use App\Shared\Abstracts\DTOs\DTO;

class ReportGenerationDTO extends DTO{
    public function __construct(
        public readonly ?string $startDate = null,
        public readonly ?string $endDate = null,
        public readonly ?iterable $cuentas = null,
        public readonly ?iterable $categorias = null,
        public readonly bool $only_categorias_fijas = false
    )
    {
    }
}