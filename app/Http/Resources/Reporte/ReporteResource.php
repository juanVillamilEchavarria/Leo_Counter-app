<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Resources\Reporte;

use App\Application\Reporte\Resolvers\AssemblerResolver;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\Enums\Statistic\PresupuestoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource encargada de serializar el resultado compuesto del módulo de reportes.
 * Ensambla los Value Objects de presentación a partir del ReporteQueryResult
 * retornado por los handlers de aplicación.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
final class ReporteResource extends JsonResource
{
    public function __construct(
        $resource,
        private readonly AssemblerResolver $assemblerResolver
    ) {
        parent::__construct($resource);
    }

    /**
     * Transforma el recurso en un arreglo serializable para HTTP.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ReporteQueryResult $result */
        $result = $this->resource;

        return [
            'KPIs' => $this->assembleIfPresent(
                MovimientoReportStatisticType::KPIS,
                $result
            ),
            'tendencia' => [
                'ingresos_vs_gastos' => $this->assembleIfPresent(
                    MovimientoReportStatisticType::INGRESOS_VS_GASTOS,
                    $result
                ),
                'balance_neto_por_fecha' => $this->assembleIfPresent(
                    MovimientoReportStatisticType::BALANCE_NETO,
                    $result
                ),
                'presupuesto' => $this->assembleIfPresent(
                    PresupuestoReportStatisticType::USED_BUDGET,
                    $result
                ),
            ],
            'distribuiciones' => [
                'por_categoria' => $this->assembleIfPresent(
                    MovimientoReportStatisticType::CATEGORY_DISTRIBUTION,
                    $result
                ),
            ],
        ];
    }

    private function assembleIfPresent($type, ReporteQueryResult $result): mixed
    {
        if (!$result->has($type)) {
            return null;
        }

        return $this->assemblerResolver->resolve($type, $result);
    }
}
