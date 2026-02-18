<?php

namespace App\Http\Controllers\Movimiento;

use App\Models\Movimiento\Movimiento;
use App\Http\Controllers\Controller;
use App\Domains\Movimiento\Service\Application\MovimientoService;
use App\Http\Requests\MovimientoEspontaneo\StoreMovimientoEspontaneoRequest;
use App\Http\Requests\MovimientoEspontaneo\UpdateMovimientoEspontaneoRequest;
use App\Domains\Movimiento\Enums\MovimientoVariants;
use App\Domains\Movimiento\Enums\ResourceEnum;
use App\Http\Requests\MovimientoEspontaneo\DestroyMovimientoEspontaneoRequest;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Client\Request;

class MovimientoEspontaneoController extends Controller
{

    public function __construct(
        private MovimientoService $movimientoService,
    )
    {
    }
    /**
     * Display a listing of the resource.
     */
    protected function props(string $title = 'Movimientos Espontaneos') : array{
        return [
            'title'=> $title,
            'NoRegistros'=> $this->movimientoService->getRecordsCount(MovimientoVariants::ESPONTANEO),
        ];
    }
    public function index()
    {
        $props = array_merge($this->props(),[
            'dia'=> Carbon::now()->format('Y-m-d'),
            'movimientos'=>$this->movimientoService->getAll(MovimientoVariants::ESPONTANEO)
        ]);
        return Inertia::render('Movimientos/Espontaneos/Index',$props);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $props = array_merge($this->props('Crear Movimiento Espontaneo'),[
            'options'=> $this->movimientoService->getOptions()
        ]);
       return Inertia::render('Movimientos/Espontaneos/Create',$props);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovimientoEspontaneoRequest $request)
    {
        $this->movimientoService->store($request->validated());
        Inertia::flash('success','Movimiento creado con exito');
        return redirect()->route('movimientosEspontaneos.index');
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
    public function edit(Movimiento $movimientoEspontaneo)
    {

        $props = array_merge($this->props('Editar Movimiento Espontaneo'),[
            'data'=>$this->movimientoService->getWithDetails($movimientoEspontaneo, ResourceEnum::EDIT),
            'options'=> $this->movimientoService->getOptions()
        ]);
        return Inertia::render('Movimientos/Espontaneos/Edit',$props);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovimientoEspontaneoRequest $request, Movimiento $movimientoEspontaneo)
    {


        $this->movimientoService->update($movimientoEspontaneo, $request->validated());
        Inertia::flash('success','Movimiento actualizado con exito');
        return redirect()->route('movimientosEspontaneos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyMovimientoEspontaneoRequest $request, Movimiento $movimientoEspontaneo )
    {
        $this->movimientoService->destroy($movimientoEspontaneo, $request->validated());
        Inertia::flash('success','Movimiento eliminado con exito');
        return redirect()->route('movimientosEspontaneos.index');
    }
}
