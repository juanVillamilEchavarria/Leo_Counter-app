<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\Contracts;

use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

/**
 * Contrato que deben implementar los casos de uso de dominios que contribuyen datos al reporte financiero.
 * Define la orquestación de consultas parciales y completas por dominio
 * sin acoplar la aplicación a detalles de infraestructura.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface ReportContributorContract
{
    /**
     * Genera y retorna los resultados para los tipos solicitados.
     *
     * @param ReporteQuery $dto Parámetros de la consulta de dominio.
     * @param array<int, ReportStatisticTypeContract> $types Tipos de métricas a calcular definidas para cada dominio.
     * @return ReporteQueryResult
     */
    public function handle(ReporteQuery $dto, array $types): ReporteQueryResult;

    /**
     * Genera la contribución completa de los datos estadísticos del dominio para el reporte global.
     *
     * @param ReporteQuery $dto Parámetros de la consulta de dominio.
     * @return ReporteQueryResult
     */
    public function contribute(ReporteQuery $dto): ReporteQueryResult;

    /**
     * Determina si este contribuidor debe ejecutarse para los tipos solicitados.
     *
     * @param array<int, ReportStatisticTypeContract> $requestedTypes
     * @return bool
     */
    public function shouldContribute(array $requestedTypes): bool;
}
