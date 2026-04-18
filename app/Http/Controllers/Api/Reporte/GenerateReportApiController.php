<?php

namespace App\Http\Controllers\Api\Reporte;

use App\Application\Reporte\Handlers\GenerateReportHandler;
use App\Application\Reporte\Contributors\GenerateMovimientoReportHandler;
use App\Application\Reporte\Mappers\ReportQueryMapper;
use App\Application\Reporte\Support\ReporteFilterOptionsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Controlador API para exponer los reportes de datos estadisticos del sistema.
 * Delega la lógica de negocio a handlers de aplicación y limita su
 * responsabilidad a la coordinación HTTP y serialización de respuestas.
 *
 * @author Juan Villamil
 * @since 1.0.0
 */
final class GenerateReportApiController extends Controller
{
    public function __construct(
        private readonly GenerateReportHandler $reportHandler,
    ) {
    }
    /**
     * Aqui podrias implementar un enpoint para generar reportes dinamicos, con estadisticas variadas, colocas los parametros en el request, deberia contener un arreglo de estadisticas solicitadas (que luego se deben mappear/convertir en su respectivo enum) y los datos de filtrado de reporte.
     * @return JsonResponse
     */
    // public function report(Request $request){
        // $types = [mappeo de tipos de estadisticas a enums, debe retornar un array de enums]
        // $dto = GenerateFinancialReportQuery::fromArray($request->validated());
        // $result= $this->reportHandler->handle($types, $dto);
        // return  ReporteResource::make($result, app(\App\Application\Reporte\Resolvers\AssemblerResolver::class))->response();
        // puedes retornar el ReporteResource normal o uno generico
    // }

}
