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

    private function props(string $title = 'Movimientos Pendientes') : array{
        return [
            'title'=> $title,
            'NoRegistros'=>$this->movimientoPendienteService->getRecordsCount(),

        ];
    }

    public function index()
    {
        $movimientos= $this->movimientoPendienteService->getAll();
        $props = array_merge($this->props(),[
            'movimientos'=>$movimientos
        ]);
        return Inertia::render('MovimientosPendientes/Index', $props);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $props = array_merge($this->props('Crear Movimiento Pendiente'),[
            'options' => $this->movimientoPendienteService->getOptions()
        ]);
        return Inertia::render('MovimientosPendientes/Create', $props);
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
    public function show(MovimientoPendiente $movimientoPendiente)
    {
        $props = array_merge($this->props('Detalle Movimiento Pendiente'),[
            'movimientos' => $this->movimientoPendienteService->getAll(),
            'data' => $this->movimientoPendienteService->getWithDetails($movimientoPendiente)
        ]);
        return Inertia::render('MovimientosPendientes/Index', $props);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MovimientoPendiente $movimientoPendiente)
    {
        $props = array_merge($this->props('Editar Movimiento Pendiente'),[
            'data' => $movimientoPendiente,
            'options' => $this->movimientoPendienteService->getOptions()
        ]);
        return Inertia::render('MovimientosPendientes/Edit', $props);
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
