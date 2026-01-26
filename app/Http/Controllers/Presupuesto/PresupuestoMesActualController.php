<?php

namespace App\Http\Controllers\Presupuesto;


use App\Domains\Presupuesto\Services\PresupuestoService;

use App\Http\Requests\Presupuesto\StoreAndUpdatePresupuestoMesActualRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Inertia\Inertia;
class PresupuestoMesActualController extends Controller
{

    public function __construct(
        private PresupuestoService $presupuestoService
    )
    {
    }
    public function index(){
        return Inertia::render('Presupuestos/MesActual/Index',[
            'title' => 'Presupuestos del mes',
            'NoRegistros' => 24,
            'fechaInicio'=> Carbon::now()->firstOfMonth(),
            'fechaFin'=> Carbon::now()->lastOfMonth()

        ]);

    }

    public function create(){
        return Inertia::render('Presupuestos/MesActual/Create',[
            'title' => 'Crear presupuesto',
            'NoRegistros' => 24,
            'options'=>$this->presupuestoService->getOptions(),
            'fechaInicio'=> Carbon::now()->firstOfMonth(),
            'fechaFin'=> Carbon::now()->lastOfMonth()
        ]);
    }

    public function store(StoreAndUpdatePresupuestoMesActualRequest $request){
        $this->presupuestoService->store($request->validated());
        Inertia::flash('success','Presupuesto creado con exito');
        return redirect()->route('presupuestos.index');
    }
}
