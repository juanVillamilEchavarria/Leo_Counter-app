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

use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;


/**
 * Contrato para los ensambladores de reportes.
 * Cada dominio contribuidor de reporte debe implementar un ensamblador por cada tipo de reporte estadistico, para garantizar que el resultado de la peticion de los datos sea el adecuado.
 * 
 * Responsabilidades:
 * - Utilizar servicios y realizar calculos a partir de los datos obtenidos, para enriquecer el reporte si es necesario
 * - Realizar el mapeo de los datos obtenidos a los DTOs correspondientes para la presentacion (incluyendo calculos realizados opcionales).
 * - Es llamado en la capa de presentacion (Resources) para construir los resultados de la peticion
 * 
 * Ejemplo de implementacion: Un ensamblaje de un tipo de reporte que necesita comparar metricas del periodo anterior con el periodo actual, el ensamblaje se encarga de calcular mediante servicios de dominio el resultado de la comparacion.
 * 
 * Para tener un ejemplo mas claro de un assambler que realiza calculos, mira el KPIAssembler
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @see App\Application\Reporte\Assemblers\Movimientos\KPIAssembler
 */
interface AssemblerContract
{
    /**
     * Determina si el ensamblador soporta el tipo de reporte
     * 
     * @param ReportStatisticTypeContract $type - el tipo de reporte
     * @return bool
     */
    public function supports(ReportStatisticTypeContract $type): bool;
    /**
     * Realiza el ensamblaje del reporte.
     * debe devolver null si el tipo de reporte no se encuentra en los resultados de la consulta
     * @param ReporteQueryResult $results - el resultado de la consulta
     * @return mixed
     */
    public function assemble(ReporteQueryResult $results): mixed;
}