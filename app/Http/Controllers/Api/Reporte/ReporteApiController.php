<?php

namespace App\Http\Controllers\Api\Reporte;

use App\Application\Reporte\DTOs\ReportGenerationDTO;
use App\Application\Reporte\Handlers\GenerateReportHandler;
use App\Application\Reporte\Contributors\GenerateMovimientoReportHandler;
use App\Application\Reporte\Mappers\ReportQueryMapper;
use App\Application\Reporte\Support\ReporteFilterOptionsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reporte\GenerateReporteRequest;
use App\Http\Resources\Reporte\ReporteResource;
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
     * @param GenerateFullFinancialReportHandler $reportHandler Handler del reporte financiero completo.
     * @param GenerateMovimientoReportHandler $movimientoHandler Handler especializado en movimientos.
     * @param ReporteFilterOptionsService $filterOptionsService Servicio de opciones de filtro.
     * @param ReportQueryMapper $mapper Mapper de DTOs de entrada.
     */
    public function __construct(
        private readonly GenerateReportHandler $reportHandler,
        private readonly ReporteFilterOptionsService $filterOptionsService,
    ) {
    }

    /**
     * Genera el reporte financiero completo usando el rango por defecto.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->reportHandler->fullReport(new ReportGenerationDTO());

        return ReporteResource::make($result, app(\App\Application\Reporte\Resolvers\AssemblerResolver::class))->response();
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
        $result = $this->reportHandler->fullReport($dto);

        return ReporteResource::make($result, app(\App\Application\Reporte\Resolvers\AssemblerResolver::class))->response();
    }

    /**
     * Aqui podrias implementar un enpoint para generar reportes dinamicos, con estadisticas variadas, colocas los parametros en el request, deberia contener un arreglo de estadisticas solicitadas (que luego se deben mappear/convertir en su respectivo enum) y los datos de filtrado de reporte.
     * @return JsonResponse
     */
    // public function report(Request $request){
        // $types = [mappeo de tipos de estadisticas a enums, debe retornar un array de enums]
        // $dto = ReportGenerationDTO::fromArray($request->validated());
        // $result= $this->reportHandler->handle($types, $dto);
        // return  ReporteResource::make($result, app(\App\Application\Reporte\Resolvers\AssemblerResolver::class))->response();
        // puedes retornar el ReporteResource normal o uno generico
    // }

    // pendiente de implementarse luego de que se refactorice los dominios relacionados a las opciones de reporte
    // /**
    //  * Retorna las opciones disponibles para los filtros del formulario.
    //  *
    //  * @return JsonResponse
    //  */
    // public function formOptions(): JsonResponse
    // {
    //     return ReporteFilterOptionsResource::make(
    //         $this->filterOptionsService->getOptions()
    //     )->response();
    // }
}
