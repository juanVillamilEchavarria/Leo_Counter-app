<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Application\Reporte\Resolvers\AssemblerResolver;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;

final class HomeResource extends JsonResource
{
    public function __construct(
        $resource,
        private readonly AssemblerResolver $assemblerResolver
    )
    {
        return parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = $this->resource;
        return [
            'KPIs'=> $this->assembleIfPresent(MovimientoReportStatisticType::KPIS, $resource),
            'tendencia'=>[
                    'ingresos_vs_gastos'=> $this->assembleIfPresent(MovimientoReportStatisticType::INGRESOS_VS_GASTOS, $resource)
                ]
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
