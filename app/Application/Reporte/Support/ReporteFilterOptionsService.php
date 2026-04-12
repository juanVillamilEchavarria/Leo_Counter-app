<?php

namespace App\Application\Reporte\Support;

use App\Application\Categoria\DTOs\IngresoAndGastoCategoriaDTO;
use App\Application\Reporte\DTOs\Form\ReporteFormOptionsDTO;
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
     * Obtiene las categorías válidas para los filtros del reporte.
     *
     * @return IngresoAndGastoCategoriaVO
     */
    public function getValidCategories(): IngresoAndGastoCategoriaVO
    {
        return new IngresoAndGastoCategoriaVO(
            ingresos: new DomainCollection($this->categoriaRepository->getForOptionsByTipoMovimiento(TipoMovimientoEnum::INGRESO)),
            gastos:   new DomainCollection($this->categoriaRepository->getForOptionsByTipoMovimiento(TipoMovimientoEnum::GASTO))
        );
    }

    /**
     * Obtiene las cuentas válidas para los filtros del reporte.
     *
     * @return DomainCollection
     */
    public function getValidAccounts(): DomainCollection
    {
        return new DomainCollection($this->cuentaRepository->getForOptions());
    }

    /**
     * Obtiene las opciones completas para el formulario de filtros del reporte.
     *
     * @return ReporteFormOptionsDTO
     */
    public function getOptions(): ReporteFormOptionsDTO
    {
        $categorias = $this->getValidCategories();

        return new ReporteFormOptionsDTO(
            categorias: new IngresoAndGastoCategoriaDTO(
                ingresos: $categorias->ingresos->getItems(),
                gastos: $categorias->gastos->getItems()
            ),
            cuentas: $this->getValidAccounts()->getItems()
        );
    }
}
