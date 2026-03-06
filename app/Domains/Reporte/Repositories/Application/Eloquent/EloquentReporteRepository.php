<?php

namespace App\Domains\Reporte\Repositories\Application\Eloquent;

// Contracts
use App\Domains\Reporte\Repositories\Contracts\ReporteRepositoryContract;
// Enums
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use Illuminate\Database\Query\Builder;
//DTOs
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
// Carbon
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EloquentReporteRepository implements ReporteRepositoryContract
{

  

    private function movimientos ():Builder{
        return DB::table('movimientos');
    }
    private function presupuestos ():Builder{
        return DB::table('presupuestos');
    }
    private function getSumQueryWithComparativeColumn (?string $comparativeColumn = 'movimientos.tipo_movimiento_id', ?string $column = 'monto' ): string {
          return "COALESCE(SUM(CASE WHEN {$comparativeColumn} = ? THEN {$column} END), 0)";
    }

    private function getSumQuery(?string $column = 'monto'): string {
        return 'COALESCE(SUM('.$column.'), 0)';
    }
    private function baseQuery(Carbon $startDate, Carbon $endDate, Builder $query, ?string $column = 'movimientos.fecha'){
        return $query->whereBetween($column, [$startDate, $endDate]);
    }

    private function queryIngresosVsGastos(ReporteQueryDTO $dto){
        
        $query = $this->movimientos();
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $date = $dto->granularityStrategy->groupBy();
        return $query
                ->selectRaw($this->getSumQueryWithComparativeColumn().' AS ingresos, '.$this->getSumQueryWithComparativeColumn().' AS gastos, '.$date.' as fecha', [TipoMovimientoEnum::INGRESO->value, TipoMovimientoEnum::GASTO->value])
                ->groupByRaw($date)->orderBy('fecha')->get();
    }


    private function queryDistributionByCategory(ReporteQueryDTO $dto, int $tipo_movimiento_id){
        $query = $this->movimientos();
        $query->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
                     ->selectRaw('categorias.nombre as categoria, '.$this->getSumQuery('movimientos.monto').' as total, COUNT(movimientos.id) as cantidad')
                     ->where('movimientos.tipo_movimiento_id', $tipo_movimiento_id);
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        return $query
        ->groupBy('categorias.id', 'categorias.nombre')
        ->orderByDesc('total')
        ->get();
        
    }

    /**
     * obtiene los ingresos ordenados por fecha, para cada una de las fechas  Ej:(enero - 200, febrero - 300)
     */
    public function getIngresos(ReporteQueryDTO $dto): Collection{
        $query = $this->movimientos()->where('tipo_movimiento_id', TipoMovimientoEnum::INGRESO->value);
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $date = $dto->granularityStrategy->groupBy();
        return $query
                ->selectRaw( $date .'as fecha, '.$this->getSumQuery('monto').' as monto')
                ->groupByRaw($date)->orderBy('fecha')->get();
    }

    /**
     * obtiene los gastos ordenados por fecha, para cada una de las fechas  Ej:(enero - 200, febrero - 300)
     */
    public function getGastos(ReporteQueryDTO $dto): Collection{
        $query = $this->movimientos()->where('tipo_movimiento_id', TipoMovimientoEnum::GASTO->value);
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $date = $dto->granularityStrategy->groupBy();
        return $query
                ->selectRaw($date.' as fecha, '.$this->getSumQuery('monto').' as monto')
                ->groupByRaw($date)->orderBy('fecha')->get();
    }

    /**
     * Obtiene los montos totales de ingresos y gastos para cada uno de los periodos Ej : (enero - (gastos : 200 , ingresos : 300))
     */
    public function getIngresosVsGastos(ReporteQueryDTO $dto): Collection{
        
        return $this->queryIngresosVsGastos($dto);
    }


    /**
     * Obtiene las categorias cada una con los movimientos registrados asociados a si misma, y el total del monto
     */
    public function getDistributionByCategory(ReporteQueryDTO $dto, int $tipo_movimiento_id): Collection{
       return $this->queryDistributionByCategory($dto, $tipo_movimiento_id);
    }

    /**
     * Suma todos los ingresos y gastos, generando el total de cada uno, al igual que el total de registros de movimientos
    */
     public function getKPIs(ReporteQueryDTO $dto): Collection{
        $query = 
        $this->movimientos()->selectRaw( $this->getSumQueryWithComparativeColumn().'AS total_ingresos, '.$this->getSumQueryWithComparativeColumn().' AS total_gastos, COUNT(movimientos.id) AS total_movimientos, '.$dto->granularityStrategy->groupBy().' as fecha', [TipoMovimientoEnum::INGRESO->value, TipoMovimientoEnum::GASTO->value]);
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query->groupByRaw($dto->granularityStrategy->groupBy());
        return $query->get();
    }

    public function getBalanceNeto(ReporteQueryDTO $dto): Collection{
        $query = $this->movimientos()->selectRaw('('.$this->getSumQueryWithComparativeColumn().' - '.$this->getSumQueryWithComparativeColumn().') AS balance, '.$dto->granularityStrategy->groupBy().' as fecha', [TipoMovimientoEnum::INGRESO->value, TipoMovimientoEnum::GASTO->value]);
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query->groupByRaw($dto->granularityStrategy->groupBy());
        return $query->get();
    }

    public function getTotalPresupuesto(ReporteQueryDTO $dto): float{
        $query = $this->presupuestos();
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query, 'presupuestos.created_at');
        return $query->sum('monto');
    }

    public function getTotalGastos(ReporteQueryDTO $dto): float{
        $query = $this->movimientos()->where('tipo_movimiento_id', TipoMovimientoEnum::GASTO->value);
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        return $query->sum('monto');
    }

}