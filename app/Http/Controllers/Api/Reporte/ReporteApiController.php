<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Controllers\Api\Reporte;

use App\Application\Reporte\Queries\GenerateFinancialReportQuery;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Reporte\Queries\ListReporteFormOptionsQuery;
use App\Application\Reporte\Handlers\GenerateReportHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reporte\GenerateReporteRequest;
use App\Http\Resources\Reporte\ReporteResource;
use App\Application\Reporte\Resolvers\AssemblerResolver;
use App\Application\Reporte\Enums\Statistics\ReportStatisticType;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Reporte\ReporteFilterOptionsResource;
/**
 * Controlador API para el módulo de Reportes.
 * Delega la lógica de negocio a handlers de aplicación y limita su
 * responsabilidad a la coordinación HTTP y serialización de respuestas.
 *
 * @author Juan Villamil
 * @since 1.0.0
 */
final class ReporteApiController extends Controller
{
    /**
     * @param GenerateReportHandler $reportHandler Handler de generacion de reportes
     */
    public function __construct(
        private readonly GenerateReportHandler $reportHandler,
        private readonly QueryBus $queryBus
    ) {
    }

    /**
     * Genera el reporte financiero completo usando el rango por defecto.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->reportHandler->__invoke( ReportStatisticType::statistics(),new GenerateFinancialReportQuery());

        return ReporteResource::make($result, app(AssemblerResolver::class))->response();
    }

    /**
     * Genera el reporte financiero completo con los filtros enviados por el cliente.
     *
     * @param GenerateReporteRequest $request
     * @return JsonResponse
     */
    public function generate(GenerateReporteRequest $request): JsonResponse
    {
        $dto = GenerateFinancialReportQuery::fromArray($request->validated());
        $result = $this->reportHandler->__invoke( ReportStatisticType::statistics(),$dto);
        return ReporteResource::make($result, app(AssemblerResolver::class))->response();
    }

    // pendiente de implementarse luego de que se refactorice los dominios relacionados a las opciones de reporte
    /**
     * Retorna las opciones disponibles para los filtros del formulario.
     *
     * @return JsonResponse
     */
    public function formOptions(): JsonResponse
    {
        return ReporteFilterOptionsResource::make(
            $this->queryBus->ask(new ListReporteFormOptionsQuery())
        )->response();
    }
}
