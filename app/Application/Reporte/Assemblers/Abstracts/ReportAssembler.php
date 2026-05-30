<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\Assemblers\Abstracts;

use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Application\Reporte\Contracts\AssemblerContract;

/**
 * Assambler base para reportes.
 * Todos los assemblers de reportes deben heredar de esta clase y satisfacer los metodos abstractos, ya que esta clase garantiza que todos los reportes retornen null si el tipo de reporte no existe en los resultados de la query (como especifica el contrato AssemblerContract)
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @see App\Application\Reporte\Contracts\AssemblerContract
 */
abstract class ReportAssembler implements AssemblerContract{

    /**
     *  tipo de reporte relacionado al ensamblaje.
     * Con este parametro se identifica si el ensamblaje debe realizarse
     * 
     * @example MovimientoReportStatisticType::BALANCE_NETO
     * @var ReportStatisticTypeContract
     */
    protected ReportStatisticTypeContract $statisticType;
    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $this->instanceof($type) && $this->statisticType === $type;
    }
    public function assemble(ReporteQueryResult $results): mixed
    {
        // Garantiza que todas las implementaciones de reportes esten validadas, devolviendo null si el reporte no existe
        if(!$results->get($this->statisticType)){
            return null;
        }
        return $this->buildAssemble($results);
    }

    /**
     * verifica la instancia del typo de reporte si concuerda con su enum de dominio
     * 
     * @param ReportStatisticTypeContract $type
     * @return bool
     * @example $type instanceof MovimientoReportStatisticType
     */
    abstract protected function instanceof(ReportStatisticTypeContract $type): bool;
    /**
     * Construye el ensamblaje de la respuesta del reporte
     * 
     * @param ReporteQueryResult $results
     * @return mixed
     */
    abstract protected function buildAssemble(ReporteQueryResult $results): mixed;

}