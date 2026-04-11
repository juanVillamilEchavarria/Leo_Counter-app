<?php

namespace App\Http\Controllers\Propietario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Propietario\Services\PropietarioService;
use App\Http\Requests\Propietario\StoreAndUpdatePropietarioRequest;
use App\Models\Propietario\Propietario;
use Inertia\Inertia;

class PropietarioController extends Controller
{
    public function __construct(
        private PropietarioService $propietarioService
    ){}
    protected function props(string $title = 'Propietarios') : array{
        return [
            'title' => $title,
            'NoRegistros' => $this->propietarioService->getRecordsCount(),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propietarios = $this->propietarioService->getAll();
        $props = array_merge($this->props(),[
            'propietarios' => $propietarios
        ]);
        return Inertia::render('Propietarios/Index',$props);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return Inertia::render('Propietarios/Create',$this->props('Crear Propietario'));
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
    public function show(Propietario $propietario)
    {
        $props = array_merge($this->props('Detalle Propietario'),[
            'propietarios' => $this->propietarioService->getAll(),
            'data'=> $this->propietarioService->getWithDetails($propietario)
        ]);
          return Inertia::render('Propietarios/Index',$props);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Propietario $propietario)
    {
        $props = array_merge($this->props('Editar Propietario'),[
            'data' => $propietario
        ]);
        return Inertia::render('Propietarios/Edit',$props);
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
