<?php

namespace App\Http\Controllers\MovimientoFijo;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Domains\MovimientoFijo\Services\MovimientoFijoService;

use App\Http\Requests\MovimientoFijo\StoreAndUpdateMovimientoFijoRequest;
use App\Models\MovimientoFijo\MovimientoFijo;

class MovimientoFijoController extends Controller
{  

    public function __construct(
        protected MovimientoFijoService $movimientoFijoService
    ) {
    }

    private function NoRegistros(){
        $this->movimientoFijoService->getRecordsCount();
        
    }
    public function index()
    {
        $movimientos= $this->movimientoFijoService->getAll();

        return Inertia::render('MovimientosFijos/Index', [
            'title' => 'Movimientos Fijos',
            'NoRegistros'=> $this->NoRegistros(),
            'movimientos' => $movimientos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('MovimientosFijos/Create', [
            'title' => 'Crear Movimiento Fijo',
            'NoRegistros'=> $this->NoRegistros(),
            'options' => $this->movimientoFijoService->getOptions()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAndUpdateMovimientoFijoRequest $request)
    {
        $this->movimientoFijoService->store($request->validated());
       Inertia::flash('success','Movimiento Fijo creado con exito');
        return redirect()->route('movimientosFijos.index');
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
    public function edit(MovimientoFijo $movimientoFijo)
    {
        return Inertia::render('MovimientosFijos/Edit', [
            'title' => 'Editar Movimiento Fijo',
            'NoRegistros'=> $this->NoRegistros(),
            'data' => $movimientoFijo,
            'options' => $this->movimientoFijoService->getOptions()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAndUpdateMovimientoFijoRequest $request, MovimientoFijo $movimientoFijo)
    {
        $this->movimientoFijoService->update($movimientoFijo, $request->validated());
        Inertia::flash('success','Movimiento Fijo actualizado con exito');
        return redirect()->route('movimientosFijos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MovimientoFijo $movimientoFijo)
    {
        $this->movimientoFijoService->destroy($movimientoFijo);
        Inertia::flash('success','Movimiento Fijo eliminado con exito');
        return redirect()->route('movimientosFijos.index');
    }

    public function toggleActive(MovimientoFijo $movimientoFijo)
    {

        $this->movimientoFijoService->toggleActive($movimientoFijo);
        Inertia::flash('success', 'Movimiento Fijo actualizado correctamente');
        return redirect()->route('movimientosFijos.index');
    }

    public function toggleRegistrarAutomaticamente(MovimientoFijo $movimientoFijo)
    {

        $this->movimientoFijoService->toggleRegistrarAutomatico($movimientoFijo);
        Inertia::flash('success', 'Movimiento Fijo actualizado correctamente');
        return redirect()->route('movimientosFijos.index');
    }
}
