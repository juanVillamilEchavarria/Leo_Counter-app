<?php

namespace App\Http\Controllers\MovimientoFijo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    public function index()
    {
        $movimientos= $this->movimientoFijoService->getAll();

        return Inertia::render('MovimientosFijos/Index', [
            'title' => 'Movimientos Fijos',
            'NoRegistros'=> 10,
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
            'NoRegistros'=> 10,
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
    public function edit(string $id)
    {
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd('desde destroy');
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
