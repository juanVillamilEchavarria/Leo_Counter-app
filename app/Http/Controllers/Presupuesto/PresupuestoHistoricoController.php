<?php

namespace App\Http\Controllers\Presupuesto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Domains\Presupuesto\Services\PresupuestoService;
use App\Domains\Presupuesto\Enums\PresupuestoVariants;

class PresupuestoHistoricoController extends Controller
{
    public function __construct(
        private PresupuestoService $presupuestoService
    ) {}

    public function index(){
        $presupuestos = $this->presupuestoService->getAllWithDetails(PresupuestoVariants::TOTAL);
        $totalRecords = $this->presupuestoService->getRecordsCount(PresupuestoVariants::TOTAL);

        return Inertia::render('Presupuestos/Historicos/Index',[
            'title' => 'Presupuestos',
            'presupuestos' => $presupuestos,
            'NoRegistros' => $totalRecords
        ]);
    }
}
