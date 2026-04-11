<?php

namespace App\Application\Reporte\Support;

use App\Domains\Categoria\Contracts\Repositories\CategoriaReadRepositoryContract;
use App\Domains\Cuenta\Contracts\Repositories\CuentaReadRepositoryContract;
use App\Shared\Domain\Collections\DomainCollection;
use App\Domains\Reporte\ValueObjects\Form\IngresoAndGastoCategoriaVO;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

/**
 * Servicio de apoyo para la obtención de opciones de filtros para el reporte.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Reporte\Support
 * @since 1.0.0
 */
final class ReporteFilterOptionsService
{
    public function __construct(
        private readonly CategoriaReadRepositoryContract $categoriaRepository,
        private readonly CuentaReadRepositoryContract $cuentaRepository
    ) {}

    /**
     * Returns the categories valid for filtering by movement type.
     */
    public function getValidCategories(): IngresoAndGastoCategoriaVO
    {
        return new IngresoAndGastoCategoriaVO(
            ingresos: new DomainCollection($this->categoriaRepository->getForOptionsByTipoMovimiento(TipoMovimientoEnum::INGRESO)),
            gastos:   new DomainCollection($this->categoriaRepository->getForOptionsByTipoMovimiento(TipoMovimientoEnum::GASTO))
        );
    }

    /**
     * Returns the accounts valid as report filters.
     */
    public function getValidAccounts(): DomainCollection
    {
        return new DomainCollection($this->cuentaRepository->getForOptions());
    }
}
