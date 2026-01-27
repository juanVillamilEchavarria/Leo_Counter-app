<?php

namespace App\Http\Controllers\Presupuesto;

use App\Domains\Presupuesto\Services\PresupuestoService;
use App\Http\Requests\Presupuesto\StoreAndUpdatePresupuestoMesActualRequest;
use App\Http\Controllers\Controller;
use App\Models\Presupuesto\Presupuesto;
use Carbon\Carbon;
use Inertia\Inertia;

use App\Domains\Presupuesto\Enums\PresupuestoVariants;

class PresupuestoMesActualController extends Controller
{
    public function __construct(
        private PresupuestoService $presupuestoService
    ) {
    }

    private function NoRegistros()
    {
        return $this->presupuestoService->getRecordsCount(PresupuestoVariants::MES_ACTUAL);
    }

    public function index()
    {
        $presupuestos = $this->presupuestoService->getAllWithDetails(PresupuestoVariants::MES_ACTUAL);
        return Inertia::render('Presupuestos/MesActual/Index', [
            'title' => 'Presupuestos del mes',
            'NoRegistros' => $this->NoRegistros(),
            'fechaInicio' => Carbon::now()->firstOfMonth(),
            'fechaFin' => Carbon::now()->lastOfMonth(),
            'presupuestos' => $presupuestos
        ]);
    }

    public function create()
    {
        return Inertia::render('Presupuestos/MesActual/Create', [
            'title' => 'Crear presupuesto',
            'NoRegistros' => $this->NoRegistros(),
            'options' => $this->presupuestoService->getOptions(),
            'fechaInicio' => Carbon::now()->firstOfMonth(),
            'fechaFin' => Carbon::now()->lastOfMonth()
        ]);
    }

    public function store(StoreAndUpdatePresupuestoMesActualRequest $request)
    {
        $this->presupuestoService->store($request->validated());
        Inertia::flash('success', 'Presupuesto creado con exito');
        return redirect()->route('presupuestosMesActual.index');
    }

    public function edit(Presupuesto $presupuesto)
    {
 
        return Inertia::render('Presupuestos/MesActual/Edit', [
            'title' => 'Editar presupuesto',
            'NoRegistros' => $this->NoRegistros(),
            'data' => $presupuesto,
            'options' => $this->presupuestoService->getOptions(),
            'fechaInicio' => $presupuesto->fecha_inicio,
            'fechaFin' => $presupuesto->fecha_final
        ]);
    }

    public function update(StoreAndUpdatePresupuestoMesActualRequest $request, Presupuesto $presupuesto)
    {
        $this->presupuestoService->update($presupuesto, $request->validated());
        Inertia::flash('success', 'Presupuesto actualizado con exito');
        return redirect()->route('presupuestosMesActual.index');
    }

    public function destroy(Presupuesto $presupuesto)
    {
        $this->presupuestoService->destroy($presupuesto);
        Inertia::flash('success', 'Presupuesto eliminado con exito');
        return redirect()->route('presupuestosMesActual.index');
    }
}
