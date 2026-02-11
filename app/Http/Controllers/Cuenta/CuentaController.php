<?php

namespace App\Http\Controllers\Cuenta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cuenta\StoreAndUpdateCuentaRequest;
use Inertia\Inertia;
use App\Models\Cuenta\Cuenta;
use App\Domains\Cuenta\Services\CuentaService;
class CuentaController extends Controller
{
    public function __construct(
        private CuentaService $cuentaService
    )
    {
    }
    /**
     * Display a listing of the resource.
     */

    private function NoRegistros(){
        return $this->cuentaService->getRecordsCount();
    }
    public function index()
    {
        
        $cuentas= $this->cuentaService->getAllAvailableWhitDetails();
        
        return Inertia::render('Cuentas/Index',[
            'title'=>'Cuentas',
            'NoRegistros'=>$this->NoRegistros(),
            'cuentas'=>$cuentas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->cuentaService->getOptions();
        return Inertia::render('Cuentas/Create',[
            'title'=>'Cuentas',
            'NoRegistros'=>$this->NoRegistros(),
            'options'=>$options
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAndUpdateCuentaRequest $request)
    {
        $this->cuentaService->store($request->validated());
        Inertia::flash('success', 'Cuenta creada correctamente');
        return redirect()->route('cuentas.index');
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
    public function edit(Cuenta $cuenta)
    {
         $options = $this->cuentaService->getOptions();
        return Inertia::render('Cuentas/Edit',[
            'title'=>'Cuentas',
            'NoRegistros'=>$this->NoRegistros(),
            'options'=>$options,
            'data'=>$cuenta,
            'can_update_saldo'=>$this->cuentaService->canUpdateSaldoInicial($cuenta)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAndUpdateCuentaRequest $request, Cuenta $cuenta)
    {
        $this->cuentaService->update($cuenta, $request->validated());
        Inertia::flash('success', 'Cuenta actualizada correctamente');
        return redirect()->route('cuentas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuenta $cuenta)
    {
        $this->cuentaService->destroy($cuenta);
        Inertia::flash('success', 'Cuenta Archivada correctamente');
        return redirect()->route('cuentas.index');
    }
    public function toggleActive(Cuenta $cuenta){
        $this->cuentaService->toggleActive($cuenta);
        Inertia::flash('success', 'Cuenta actualizada correctamente');
        return redirect()->route('cuentas.index');
    }
}
