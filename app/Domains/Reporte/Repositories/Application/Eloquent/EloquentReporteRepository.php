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
// Query Builder
use App\Shared\QueryBuilders\ConditionalAggregateBuilder;
// Strategies / Resolvers
use App\Domains\Reporte\Strategies\Resolvers\Relations\QueryIdRelationResolver;

class EloquentReporteRepository implements ReporteRepositoryContract
{

    public function __construct(
        private QueryIdRelationResolver $queryIdRelationResolver
    )
    {
    }

    /**
     * obtiene los ingresos ordenados por fecha, para cada una de las fechas  Ej:(enero - 200, febrero - 300)
     */
    public function getIngresos(ReporteQueryDTO $dto): Collection{
        $query = $this->movimientos()->where('tipo_movimiento_id', TipoMovimientoEnum::INGRESO->value);
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->resolveRelationQuery($query, $dto);
        $date = $dto->granularityStrategy->groupBy();
        return $query
                ->selectRaw("{$date} as fecha, {$this->getSumQuery('monto')} as monto")
                ->groupByRaw($date)->orderBy('fecha')->get();
    }

    /**
     * obtiene los gastos ordenados por fecha, para cada una de las fechas  Ej:(enero - 200, febrero - 300)
     */
    public function getGastos(ReporteQueryDTO $dto): Collection{
        $query = $this->movimientos()->where('tipo_movimiento_id', TipoMovimientoEnum::GASTO->value);
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->resolveRelationQuery($query, $dto);
        $date = $dto->granularityStrategy->groupBy();
        return $query
                ->selectRaw("{$date} as fecha, {$this->getSumQuery('monto')} as monto")
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
    public function getCategoryDistribution(ReporteQueryDTO $dto): Collection{
       return $this->queryDistributionByCategory($dto);
    }

    /**
     * Suma todos los ingresos y gastos, generando el total de cada uno, al igual que el total de registros de movimientos
    */
     public function getKPIs(ReporteQueryDTO $dto): Collection{
        $query = $this->movimientos()->
                selectRaw("{$this->getConditionalSumQuery()} AS total_ingresos,
                {$this->getConditionalSumQuery()} AS total_gastos, 
                {$this->getMovimientosCountQuery()} AS total_movimientos, 
                {$dto->granularityStrategy->groupBy()} as fecha",
                [TipoMovimientoEnum::INGRESO->value,
                 TipoMovimientoEnum::GASTO->value]);

        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->resolveRelationQuery($query, $dto);
        $query->groupByRaw($dto->granularityStrategy->groupBy());
        return $query->get();
    }

    public function getBalanceNeto(ReporteQueryDTO $dto): Collection{
        $query = $this->movimientos()
                ->selectRaw("({$this->getConditionalSumQuery()} - {$this->getConditionalSumQuery()}) AS balance, {$dto->granularityStrategy->groupBy()} as fecha",
                [TipoMovimientoEnum::INGRESO->value, 
                TipoMovimientoEnum::GASTO->value]);

        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->resolveRelationQuery($query, $dto);
        $query->groupByRaw($dto->granularityStrategy->groupBy());
        return $query->get();
    }

    public function getTotalPresupuesto(ReporteQueryDTO $dto): float{
        $query = $this->presupuestos();
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query, 'presupuestos.created_at');
        $query = $this->resolveRelationQuery($query, $dto, 'presupuestos');
        return $query->sum('monto');
    }

    public function getTotalGastos(ReporteQueryDTO $dto): float{
        $query = $this->movimientos()->where('tipo_movimiento_id', TipoMovimientoEnum::GASTO->value);
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->resolveRelationQuery($query, $dto);
        return $query->sum('monto');
    }
    private function movimientos ():Builder{
        return DB::table('movimientos');
    }
    private function presupuestos ():Builder{
        return DB::table('presupuestos');
    }

    /**
     * obtiene la query derivada del strategy con la query de acuerdo con el tipo de relacion del reporte
     */
    private function resolveRelationQuery(Builder $query, ReporteQueryDTO $reporteQueryDTO, ?string $table = 'movimientos'): Builder{
        return $this->queryIdRelationResolver->resolve($query, $reporteQueryDTO, $table);
    }

    private function getConditionalSumQuery(){
        return ConditionalAggregateBuilder::make()
            ->aggregate('SUM')
            ->column('movimientos.monto')
            ->conditionColumn('movimientos.tipo_movimiento_id')
            ->useCoalesce(true)
            ->build();
    }
    private function getConditionalCountQuery(){
        return ConditionalAggregateBuilder::make()
            ->aggregate('COUNT')
            ->column('movimientos.id')
            ->conditionColumn('movimientos.tipo_movimiento_id')
            ->useCoalesce(true)
            ->build();
    }
    private function getSumQuery(?string $column = 'monto'): string {
        return ConditionalAggregateBuilder::make()
            ->aggregate('SUM')
            ->column($column)
            ->useCoalesce(true)
            ->build();
            
    }
    private function getMovimientosCountQuery(){
        return ConditionalAggregateBuilder::make()
            ->aggregate('COUNT')
            ->column('movimientos.id')
            ->useCoalesce(false)
            ->build();
    }
    private function baseQuery(Carbon $startDate, Carbon $endDate, Builder $query, ?string $column = 'movimientos.fecha'){
        return $query->whereBetween($column, [$startDate, $endDate]);
    }

    private function queryIngresosVsGastos(ReporteQueryDTO $dto){
        
        $query = $this->movimientos();
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $date = $dto->granularityStrategy->groupBy();
        $query = $this->resolveRelationQuery($query, $dto);
        return $query
                ->selectRaw("{$this->getConditionalSumQuery()} AS ingresos,
                 {$this->getConditionalSumQuery()} AS gastos,
                  {$this->getConditionalCountQuery()} AS count_ingresos, 
                  {$this->getConditionalCountQuery()} AS count_gastos, 
                  {$date} as fecha",
                  [TipoMovimientoEnum::INGRESO->value,
                   TipoMovimientoEnum::GASTO->value, 
                   TipoMovimientoEnum::INGRESO->value,
                   TipoMovimientoEnum::GASTO->value])
                ->groupByRaw($date)
                ->orderBy('fecha')
                ->get();
    }


    private function queryDistributionByCategory(ReporteQueryDTO $dto){
        $query = $this->movimientos();
        $query->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
                     ->selectRaw("categorias.nombre as categoria,
                      {$this->getSumQuery('movimientos.monto')} as total, 
                      {$this->getMovimientosCountQuery()} as cantidad");
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->resolveRelationQuery($query, $dto);
        return $query
        ->groupBy('categorias.id', 'categorias.nombre')
        ->orderByDesc('total')
        ->get();
        
    }
}