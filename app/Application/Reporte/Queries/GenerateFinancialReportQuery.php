<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\Queries;


/**
 * Query que se encarga de representar los datos necesarios para generar un reporte
 * Esta clase debe ser utilizada como un contenedor de datos para transportar la información necesaria para generar un reporte desde la capa de presentación hasta la capa de aplicación
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class GenerateFinancialReportQuery{
    /**
     * @param string|null $startDate Fecha de inicio del periodo para el cual se generará el reporte.
     * @param string|null $endDate Fecha de fin del periodo para el cual se generará el reporte.
     * @param iterable|null $cuentas ids de Cuentas seleccionadas para filtrar el reporte.
     * @param iterable|null $categorias ids de Categorias seleccionadas para filtrar el reporte.
     * @param bool $only_categorias_fijas booleano que Indica si el reporte debe incluir solo las categorias fijas
     */
    public function __construct(
        public readonly ?string $startDate = null,
        public readonly ?string $endDate = null,
        public readonly ?iterable $cuentas = null,
        public readonly ?iterable $categorias = null,
        public readonly bool $only_categorias_fijas = false
    )
    {
    }
}
