<?php

namespace App\Http\Controllers\Api\Reporte;

use App\Application\Reporte\DTOs\ReportGenerationDTO;
use App\Application\Reporte\Handlers\GenerateFullFinancialReportHandler;
use App\Application\Reporte\Handlers\GenerateMovimientoReportHandler;
use App\Application\Reporte\Mappers\ReportQueryMapper;
use App\Application\Reporte\Support\ReporteFilterOptionsService;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reporte\GenerateReporteRequest;
use App\Http\Resources\Reporte\FullReporteResource;
use App\Http\Resources\Reporte\ReporteFilterOptionsResource;
use Illuminate\Http\JsonResponse;

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
     * @param GenerateFullFinancialReportHandler $fullReportHandler Handler del reporte financiero completo.
     * @param GenerateMovimientoReportHandler $movimientoHandler Handler especializado en movimientos.
     * @param ReporteFilterOptionsService $filterOptionsService Servicio de opciones de filtro.
     * @param ReportQueryMapper $mapper Mapper de DTOs de entrada.
     */
    public function __construct(
        private readonly GenerateFullFinancialReportHandler $fullReportHandler,
        private readonly GenerateMovimientoReportHandler $movimientoHandler,
        private readonly ReporteFilterOptionsService $filterOptionsService,
        private readonly ReportQueryMapper $mapper,
    ) {
    }

    /**
     * Genera el reporte financiero completo usando el rango por defecto.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->fullReportHandler->handle(new ReportGenerationDTO());

        return FullReporteResource::make($result)->response();
    }

    /**
     * Genera el reporte financiero completo con los filtros enviados por el cliente.
     *
     * @param GenerateReporteRequest $request
     * @return JsonResponse
     */
    public function generate(GenerateReporteRequest $request): JsonResponse
    {
        $dto = ReportGenerationDTO::fromArray($request->validated());
        $result = $this->fullReportHandler->handle($dto);

        return FullReporteResource::make($result)->response();
    }

    /**
     * Retorna únicamente los KPIs del periodo solicitado.
     *
     * @param GenerateReporteRequest $request
     * @return JsonResponse
     */
    public function kpis(GenerateReporteRequest $request): JsonResponse
    {
        $generationDTO = ReportGenerationDTO::fromArray($request->validated());
        $queryDTO = $this->mapper->map($generationDTO);
        $result = $this->movimientoHandler->handle(
            $queryDTO,
            [MovimientoReportStatisticType::KPIS]
        );

        return FullReporteResource::make($result)->response();
    }

    /**
     * Retorna las opciones disponibles para los filtros del formulario.
     *
     * @return JsonResponse
     */
    public function formOptions(): JsonResponse
    {
        return ReporteFilterOptionsResource::make(
            $this->filterOptionsService->getOptions()
        )->response();
    }
}
