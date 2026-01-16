<?php

namespace App\Http\Controllers\Propietario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Propietario\Services\PropietarioService;
use App\Http\Requests\Propietario\StoreAndUpdatePropietarioRequest;
use App\Models\Propietario\Propietario;
use Inertia\Inertia;

class PropietarioController extends Controller
{
    public function __construct(
        private PropietarioService $propietarioService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propietarios = $this->propietarioService->getAll();
        return Inertia::render('Propietarios/Index',[
            'title' => 'Propietarios',
            'NoRegistros' => $this->propietarioService->getRecordsCount(),
            'propietarios' => $propietarios
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return Inertia::render('Propietarios/Create',[
            'title' => 'Crear Propietario'
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAndUpdatePropietarioRequest $request)
    {
        $this->propietarioService->store($request->validated());
        Inertia::flash('success','Propietario creado con exito');
        return redirect()->route('propietarios.index');
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
    public function edit(Propietario $propietario)
    {
        return Inertia::render('Propietarios/Edit',[
            'title' => 'Editar Propietario',
            'data' => $propietario
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAndUpdatePropietarioRequest $request, Propietario $propietario)
    {
        $this->propietarioService->update($propietario, $request->validated());
        Inertia::flash('success','Propietario actualizado con exito');
        return redirect()->route('propietarios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Propietario $propietario)
    {
        $this->propietarioService->destroy($propietario);
        Inertia::flash('success','Propietario eliminado con exito');
        return redirect()->route('propietarios.index');
    }
}
