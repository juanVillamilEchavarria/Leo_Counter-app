<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Mappers\Eloquent;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelIncomeExpenseCollection;
use App\Domains\Reporte\Contracts\Collections\Movimientos\IncomeExpenseCollectionContract;
use App\Domains\Reporte\ValueObjects\Financial\IncomeExpensePeriodVO;
use Illuminate\Support\Collection;

/**
 * Mapper encargado de instanciar collections declarados por el dominio, en este caso de IncomeExpenseCollectionContract, a partir de los resultados obtenidos en las consultas de Eloquent, específicamente para el reporte financiero.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @see App\Domains\Reporte\Contracts\Collections\Movimientos\IncomeExpenseCollectionContract
 */
final class FinancialPeriodMapper
{
    public function map(Collection $rows): IncomeExpenseCollectionContract
    {
        $mapped = $rows->map(static function ($row) {
            return new IncomeExpensePeriodVO(
                (string) $row->fecha,
                (float) $row->ingresos,
                (float) $row->gastos,
                (int) $row->count_ingresos,
                (int) $row->count_gastos
            );
        });

        return LaravelIncomeExpenseCollection::make($mapped);
    }
}
