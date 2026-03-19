<?php

namespace App\Http\Controllers\Api\Reporte;
use App\Domains\Reporte\Services\Application\ReporteService;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reporte\GenerateReporteRequest;
use Illuminate\Http\Request;
class ReporteApiController extends Controller
{
    public function __construct(
        private ReporteService $reporteService
    )
    {
    }

    public function index(){
        return $this->reporteService->getFullReport([]);
    }

    public function generate(GenerateReporteRequest $request){
        return $this->reporteService->getFullReport($request->validated());
    }

    public function formOptions(){
        return $this->reporteService->getOptions();
    }
}
