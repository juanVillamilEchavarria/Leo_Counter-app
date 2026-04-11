<?php

namespace App\Domains\Reporte\Contracts\Repositories;

use App\Shared\Domain\Contracts\Reporte\ReporteQueryTypeContract;
use App\Domains\Reporte\Enums\ReporteRepositoryType;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Shared\Domain\Collections\DomainCollection;

/**
 * Contrato para las implementaciones de los query port
 * Cada modulo que afecte reportes debe tener un query port que implementa este contrato
 * Ejemplo: MovimientoQueryPort
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Reporte\Contracts
 * @since 1.0.0
 * @version 1.0.0
 */
interface ReporteModelRepositoryContract
{
    /**
     * Define si el tipo de reporte es soportado por el query handler manager
     * @param ReporteRepositoryType $type
     * @return bool
     */
    public function supports(ReporteRepositoryType $type): bool;
    /**
     * Obtiene una estadistica
     * @param ReporteQueryTypeContract $type
     * @param ReporteQueryDTO $dto
     * @return mixed - pues puede ser un int, float, string, DomainCollection, etc
     */
    public function get(ReporteQueryTypeContract $type, ReporteQueryDTO $dto): mixed;
    /**
     * Obtiene multiples estadisticas
     * @param array<ReporteQueryTypeContract> $types
     * @param ReporteQueryDTO $dto
     * @return ReporteQueryResult
     */
    public function getMultiple(array $types, ReporteQueryDTO $dto): ReporteQueryResult;
}