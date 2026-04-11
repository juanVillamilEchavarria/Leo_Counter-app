<?php

namespace App\Domains\Reporte\ValueObjects\Form;

use Illuminate\Support\Collection;
use App\Shared\Domain\Collections\DomainCollection;
use App\Shared\Domain\ValueObjects\ValueObject;
use App\Shared\Abstracts\DTOs\DTO;
/**
 * DTO encargado de representar las opciones de filtros del reporte
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @package App\Domains\Reporte\ValueObjects
 * @version 1.0.0
 */
final class ReporteFilterOptionsVO extends DTO
{
    public function __construct(
        public IngresoAndGastoCategoriaVO $categorias,
        public DomainCollection $cuentas
    ) {
    }
}
