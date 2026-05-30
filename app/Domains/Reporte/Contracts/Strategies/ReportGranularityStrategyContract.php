<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Reporte\Contracts\Strategies;

/**
 * Contrato para las estrategias de agrupamiento de reportes segun la granularidad
 * Cada tipo de granularidad del reporte, debe implementar esta interfaz
 * Las implementaciones deben garantizar que las consultas se agrupen correctamente
 * Ejemplo : DailyReportGranularityStrategy
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface ReportGranularityStrategyContract
{
    /**
     * Verifica si la estrategia soporta la cantidad de dias indicada
     * 
     * @param int $days Cantidad de dias a agrupar
     * @return bool
     */
    public function supports(int $days);
    /**
     * Devuelve el formato de agrupamiento
     * Ejemplo en SQL : DATE(fecha)
     * 
     * @return string
     */
    public function groupBy(): string;
}