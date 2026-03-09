<?php

namespace App\Http\Controllers\Api\Reporte;
use App\Domains\Reporte\Services\Application\ReporteService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Reporte\ReporteApiRequest;

class ReporteApiController extends Controller
{
    public function __construct(
        private ReporteService $reporteService
    )
    {
    }

    public function index(ReporteApiRequest $request){
        return $this->reporteService->getFullReport($request->validated());
    }

    public function formOptions(){
        return $this->reporteService->getOptions()->toArray();
    }
}
