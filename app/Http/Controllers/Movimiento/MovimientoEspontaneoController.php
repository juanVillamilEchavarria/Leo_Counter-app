<?php

namespace App\Http\Controllers\Movimiento;

use App\Http\Controllers\Controller;
use App\Domains\Movimiento\Service\MovimientoService;
use App\Shared\Services\BalanceCheckerService;
use App\Http\Requests\StoreAndUpdateMovimientoEspontaneoRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Domains\Movimiento\Enums\MovimientoVariants;
use App\Models\Cuenta\Cuenta;
use Inertia\Inertia;

class MovimientoEspontaneoController extends Controller
{

    public function __construct(
        private MovimientoService $movimientoService,
        private BalanceCheckerService $balanceCheckerService
    )
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Movimientos/Espontaneos/Index',[
            'title'=>'Movimientos Espontaneos',
            'dia' => Carbon::now()->format('Y-m-d'),
            'NoRegistros'=> 24,
            'movimientos'=>$this->movimientoService->getAll(MovimientoVariants::ESPONTANEO)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return Inertia::render('Movimientos/Espontaneos/Create',[
        'title'=> 'Crear Movimiento Espontaneo',
        'NoRegistros'=> 24,
        'options'=> $this->movimientoService->getOptions()
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAndUpdateMovimientoEspontaneoRequest $request)
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
    public function edit(string $id)
    {
        //
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
        //
    }

    public function validateSaldo(Cuenta $cuenta, float $monto){
        return response()->json([
            'allowed'=>(bool) $this->balanceCheckerService->canAfford($cuenta->id, $monto)
        ]);
    }
}
