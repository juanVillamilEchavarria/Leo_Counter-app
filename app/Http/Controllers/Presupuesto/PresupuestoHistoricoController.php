<?php

namespace App\Http\Controllers\Presupuesto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Domains\Presupuesto\Services\Application\PresupuestoService;
use App\Domains\Presupuesto\Enums\PresupuestoVariants;

class PresupuestoHistoricoController extends Controller
{
    public function __construct(
        private PresupuestoService $presupuestoService
    ) {}

    public function index()
    {
        $totalRecords = $this->presupuestoService->getRecordsCount(PresupuestoVariants::HISTORICO);

        return Inertia::render('Presupuestos/Historicos/Index', [
            'title' => 'Presupuestos Historicos',
            'NoRegistros' => $totalRecords
        ]);
    }
}
