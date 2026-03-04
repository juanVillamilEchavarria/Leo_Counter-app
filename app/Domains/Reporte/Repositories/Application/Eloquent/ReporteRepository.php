<?php

namespace App\Domains\Reporte\Repositories\Application\Eloquent;

// Contracts
use App\Domains\Reporte\Repositories\Contracts\ReporteRepositoryContract;
// Enums
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use Illuminate\Database\Query\Builder;
// Carbon
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReporteRepository implements ReporteRepositoryContract
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

    private function queryIngresosVsGastos(Carbon $startDate, Carbon $endDate){
        
        $query = $this->movimientos();
        $query = $this->baseQuery($startDate, $endDate, $query);
        return $query
                ->selectRaw($this->getSumQueryWithComparativeColumn().' AS ingresos, '.$this->getSumQueryWithComparativeColumn().' AS gastos, DATE(fecha) as fecha', [TipoMovimientoEnum::INGRESO->value, TipoMovimientoEnum::GASTO->value])
                ->groupByRaw('DATE(fecha)')->orderBy('fecha')->get();
    }


    private function queryDistributionByCategory(Carbon $startDate, Carbon $endDate, int $tipo_movimiento_id){
        $query = $this->movimientos();
        $query->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
                     ->selectRaw('categorias.nombre as categoria, '.$this->getSumQuery('movimientos.monto').' as total, COUNT(movimientos.id) as cantidad')
                     ->where('movimientos.tipo_movimiento_id', $tipo_movimiento_id);
        $query = $this->baseQuery($startDate, $endDate, $query);
        return $query
        ->groupBy('categorias.id', 'categorias.nombre')
        ->orderByDesc('total')
        ->get();
        
    }

    /**
     * obtiene los ingresos ordenados por fecha, para cada una de las fechas  Ej:(enero - 200, febrero - 300)
     */
    public function getIngresos(Carbon $startDate, Carbon $endDate): Collection{
        $query = $this->movimientos()->where('tipo_movimiento_id', TipoMovimientoEnum::INGRESO->value);
        $query = $this->baseQuery($startDate, $endDate, $query);
        return $query
                ->selectRaw('DATE(fecha) as fecha, '.$this->getSumQuery('monto').' as monto')
                ->groupByRaw('DATE(fecha)')->orderBy('fecha')->get();
    }

    /**
     * obtiene los gastos ordenados por fecha, para cada una de las fechas  Ej:(enero - 200, febrero - 300)
     */

    public function getGastos(Carbon $startDate, Carbon $endDate): Collection{
        $query = $this->movimientos()->where('tipo_movimiento_id', TipoMovimientoEnum::GASTO->value);
        $query = $this->baseQuery($startDate, $endDate, $query);
        return $query
                ->selectRaw('DATE(fecha) as fecha, '.$this->getSumQuery('monto').' as monto')
                ->groupByRaw('DATE(fecha)')->orderBy('fecha')->get();
    }

    /**
     * Obtiene los montos totales de ingresos y gastos para cada uno de los periodos Ej : (enero - (gastos : 200 , ingresos : 300))
     */
    public function getIngresosVsGastos(Carbon $startDate, Carbon $endDate): Collection{
        
        return $this->queryIngresosVsGastos($startDate, $endDate);
    }


    /**
     * Obtiene las categorias cada una con los movimientos registrados asociados a si misma, y el total del monto
     */
    public function getDistributionByCategory(Carbon $startDate, Carbon $endDate, int $tipo_movimiento_id): Collection{
       return $this->queryDistributionByCategory($startDate, $endDate, $tipo_movimiento_id);
    }

    /**
     * Suma todos los ingresos y gastos, generando el total de cada uno, al igual que el total de registros de movimientos
    */
     public function getKPIs(Carbon $startDate, Carbon $endDate): Collection{
        $query = 
        $this->movimientos()->selectRaw( $this->getSumQueryWithComparativeColumn().'AS total_ingresos, '.$this->getSumQueryWithComparativeColumn().' AS total_gastos, COUNT(movimientos.id) AS total_movimientos, DATE(fecha) as fecha', [TipoMovimientoEnum::INGRESO->value, TipoMovimientoEnum::GASTO->value]);
        $query = $this->baseQuery($startDate, $endDate, $query);
        $query->groupByRaw('fecha');
        return $query->get();
    }

    public function getBalanceNeto(Carbon $startDate, Carbon $endDate): Collection{
        $query = $this->movimientos()->selectRaw('('.$this->getSumQueryWithComparativeColumn().' - '.$this->getSumQueryWithComparativeColumn().') AS balance, DATE(fecha) as fecha', [TipoMovimientoEnum::INGRESO->value, TipoMovimientoEnum::GASTO->value]);
        $query = $this->baseQuery($startDate, $endDate, $query);
        $query->groupByRaw('fecha');
        return $query->get();
    }

    public function getTotalPresupuesto(Carbon $startDate, Carbon $endDate): float{
        $query = $this->presupuestos();
        $query = $this->baseQuery($startDate, $endDate, $query, 'fecha');
        return $query->sum('monto');
    }

    public function getTotalGastos(Carbon $startDate, Carbon $endDate): float{
        $query = $this->movimientos()->where('tipo_movimiento_id', TipoMovimientoEnum::GASTO->value);
        $query = $this->baseQuery($startDate, $endDate, $query);
        return $query->sum('monto');
    }

}