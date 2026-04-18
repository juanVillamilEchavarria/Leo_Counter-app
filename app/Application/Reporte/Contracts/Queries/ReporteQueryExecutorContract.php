<?php

namespace App\Application\Reporte\Contracts\Queries;

use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQuery;

/**
 * Contrato que representa un query handler (una generacion de reporte estadistico) por dominio
 * cada dominio que influya en el modulo de reportes, debe implementar queryHandlers los cuales cada uno son responsables de obtener una sola estadistica de reporte
 * Ejemplo de concepto: obtener la cantidad de gastos por periodo en movimientos
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Reporte\Contracts
 * @since 1.0.0
 * @version 1.0.0
 */
interface ReporteQueryExecutorContract
{
    /**
     * Determina si el handler soporta el tipo de estadistica que se desea obtener
     * 
     * @param ReportStatisticTypeContract $type
     * @return bool
     */
    public function supports(ReportStatisticTypeContract $type): bool;

    /**
     * Obtiene el reporte estadistico
     * [Ejecuta la query a nivel de base de datos]
     * @param ReporteQuery $dto
     * @return mixed
     */
    public function handle(ReporteQuery $dto): mixed;
}
