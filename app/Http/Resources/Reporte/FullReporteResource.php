<?php

namespace App\Http\Resources\Reporte;

use App\Application\Reporte\Assemblers\Movimientos\IngresosVsGastosAssembler;
use App\Application\Reporte\Assemblers\Movimientos\BalanceNetoAssembler;
use App\Application\Reporte\Assemblers\Movimientos\KPIAssembler;
use App\Application\Reporte\Assemblers\Movimientos\CategoryDistributionAssembler;
use App\Application\Reporte\Assemblers\Presupuestos\UsedBudgetAssembler;
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
final class FullReporteResource extends JsonResource
{
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
        $kpis = app(KPIAssembler::class)->assemble($result);
        $ingresosVsGastos = app(IngresosVsGastosAssembler::class)->assemble($result);
        $distribucionPorCategoria = app(CategoryDistributionAssembler::class)->assemble($result);
        $presupuesto = app(UsedBudgetAssembler::class)->assemble($result);
        $balance = app(BalanceNetoAssembler::class)->assemble($result);
        return [
            'KPIs'=> $kpis,
            'tendencia'=> [
                'ingresos_vs_gastos'=> $ingresosVsGastos,
                'balance_neto_por_fecha'=> $balance,
                'presupuesto'=> $presupuesto
            ],
            'distribuiciones'=>[
                'por_categoria'=> $distribucionPorCategoria,
            ],
        ];
    }
}
