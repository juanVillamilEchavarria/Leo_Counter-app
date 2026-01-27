<?php

namespace App\Http\Controllers\Presupuesto;

use App\Http\Controllers\Controller;
use App\Domains\Presupuesto\Services\PresupuestoService;
use App\Http\Requests\Presupuesto\StoreAndUpdatePresupuestoPorPeriodoRequest;
use App\Models\Presupuesto\Presupuesto;
use Inertia\Inertia;

use App\Domains\Presupuesto\Enums\PresupuestoVariants;

class PresupuestoPorPeriodoController extends Controller
{
    public function __construct(
        private PresupuestoService $presupuestoService
    ) {
    }

    private function NoRegistros()
    {
        return $this->presupuestoService->getRecordsCount(
            PresupuestoVariants::POR_PERIODO
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presupuestos = $this->presupuestoService->getAllWithDetails(PresupuestoVariants::POR_PERIODO);
        return Inertia::render('Presupuestos/PorPeriodo/Index', [
            'title' => 'Presupuestos Por Período',
            'NoRegistros' => $this->NoRegistros(),
            'presupuestos' => $presupuestos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Presupuestos/PorPeriodo/Create', [
            'title' => 'Crear Presupuesto Por Período',
            'NoRegistros' => $this->NoRegistros(),
            'options' => $this->presupuestoService->getOptions()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAndUpdatePresupuestoPorPeriodoRequest $request)
    {
        $this->presupuestoService->store($request->validated());
        Inertia::flash('success', 'Presupuesto por período creado con éxito');
        return redirect()->route('presupuestosPorPeriodo.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presupuesto $presupuesto)
    {
        return Inertia::render('Presupuestos/PorPeriodo/Edit', [
            'title' => 'Editar Presupuesto Por Período',
            'NoRegistros' => $this->NoRegistros(),
            'data' => $presupuesto,
            'options' => $this->presupuestoService->getOptions()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAndUpdatePresupuestoPorPeriodoRequest $request, Presupuesto $presupuesto)
    {
        $this->presupuestoService->update($presupuesto, $request->validated());
        Inertia::flash('success', 'Presupuesto por período actualizado con éxito');
        return redirect()->route('presupuestosPorPeriodo.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presupuesto $presupuesto)
    {
        $this->presupuestoService->destroy($presupuesto);
        Inertia::flash('success', 'Presupuesto por período eliminado con éxito');
        return redirect()->route('presupuestosPorPeriodo.index');
    }
}
