<?php

namespace App\Http\Controllers\MovimientoPendiente;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Domains\MovimientoPendiente\Services\MovimientoPendienteService;
use App\Http\Requests\MovimientoPendiente\StoreAndUpdateMovimientoPendienteRequest;
use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Http\Requests\MovimientoPendiente\MarkAsDoneRequest;
class MovimientoPendienteController extends Controller
{
    public function __construct(
        protected MovimientoPendienteService $movimientoPendienteService
    ) {
    }

    private function NoRegistros(){
        return $this->movimientoPendienteService->getRecordsCount();
    }

    public function index()
    {
        $movimientos= $this->movimientoPendienteService->getAll();

        return Inertia::render('MovimientosPendientes/Index', [
            'title' => 'Movimientos Pendientes',
            'NoRegistros'=> $this->NoRegistros(),
            'movimientos' => $movimientos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('MovimientosPendientes/Create', [
            'title' => 'Crear Movimiento Pendiente',
            'NoRegistros'=> $this->NoRegistros(),
            'options' => $this->movimientoPendienteService->getOptions()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAndUpdateMovimientoPendienteRequest $request)
    {
        $this->movimientoPendienteService->store($request->validated());
        Inertia::flash('success','Movimiento Pendiente creado con exito');
        return redirect()->route('movimientosPendientes.index');
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
    public function edit(MovimientoPendiente $movimientoPendiente)
    {
        return Inertia::render('MovimientosPendientes/Edit', [
            'title' => 'Editar Movimiento Pendiente',
            'NoRegistros'=> $this->NoRegistros(),
            'data' => $movimientoPendiente,
            'options' => $this->movimientoPendienteService->getOptions()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAndUpdateMovimientoPendienteRequest $request, MovimientoPendiente $movimientoPendiente)
    {
        $this->movimientoPendienteService->update($movimientoPendiente, $request->validated());
        Inertia::flash('success','Movimiento Pendiente actualizado con exito');
        return redirect()->route('movimientosPendientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MovimientoPendiente $movimientoPendiente)
    {
        $this->movimientoPendienteService->destroy($movimientoPendiente);
        Inertia::flash('success','Movimiento Pendiente eliminado con exito');
        return redirect()->route('movimientosPendientes.index');
    }

    public function markAsDone(MarkAsDoneRequest $request, MovimientoPendiente $movimientoPendiente){
         $this->movimientoPendienteService->markAsDone($movimientoPendiente, $request->validated());
         Inertia::flash('success','Movimiento Pendiente marcado como realizado, miralo en la tabla de movimientos');
         return redirect()->route('movimientosPendientes.index');
    }
}
