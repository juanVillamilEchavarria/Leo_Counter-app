<?php

namespace App\Http\Controllers\Api\Reporte;

use App\Application\Reporte\Services\ReporteService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reporte\GenerateReporteRequest;
use App\Http\Resources\Reporte\FullReporteResource;
use App\Http\Resources\Reporte\ReporteFilterOptionsResource;

class ReporteApiController extends Controller
{
    public function __construct(
        private ReporteService $reporteService
    )
    {
    }

    public function index()
    {
        return FullReporteResource::make($this->reporteService->getFullReport([]));
    }

    public function generate(GenerateReporteRequest $request)
    {
        return FullReporteResource::make($this->reporteService->getFullReport($request->validated()));
    }

    public function formOptions()
    {
        return ReporteFilterOptionsResource::make($this->reporteService->getOptions());
    }
}
