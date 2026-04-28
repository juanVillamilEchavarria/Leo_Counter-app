<?php

namespace App\Http\Controllers\Cuenta;

use App\Application\Cuenta\Commands\StoreCuentaCommand;
use App\Application\Cuenta\Commands\UpdateCuentaCommand;
use App\Application\Cuenta\Commands\DestroyCuentaCommand;
use App\Application\Cuenta\Commands\ToggleCuentaCommand;
use App\Application\Cuenta\DTOs\CuentaEditDTO;
use App\Http\Controllers\Controller;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Cuenta\Queries\ListAllCuentasWithDetailsQuery;
use App\Application\Cuenta\Queries\ListCuentasRecordsCountQuery;
use App\Application\Cuenta\Queries\ListCuentaFormOptionsQuery;
use App\Application\Cuenta\Queries\GetCuentaForEditQuery;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Http\Requests\Cuenta\StoreAndUpdateCuentaRequest;
use Inertia\Inertia;

class CuentaController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private Dispatcher $dispatcher,
    ) {}

    private function NoRegistros(): int
    {
        return $this->queryBus->ask(new ListCuentasRecordsCountQuery());
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuentas = $this->queryBus->ask(new ListAllCuentasWithDetailsQuery());

        return Inertia::render('Cuentas/Index', [
            'title' => 'Cuentas',
            'NoRegistros' => $this->NoRegistros(),
            'cuentas' => $cuentas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->queryBus->ask(new ListCuentaFormOptionsQuery());

        return Inertia::render('Cuentas/Create', [
            'title' => 'Cuentas',
            'NoRegistros' => $this->NoRegistros(),
            'options' => $options,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAndUpdateCuentaRequest $request)
    {
        $command = new StoreCuentaCommand(
            nombre: $request->nombre,
            notas: $request->notas,
            saldo_inicial: $request->saldo_inicial,
            propietario_id: $request->propietario_id,
            tipo_cuenta_id: $request->tipo_cuenta_id,
        );

        $this->dispatcher->dispatch($command);
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
    public function edit(int $id)
    {
        $options = $this->queryBus->ask(new ListCuentaFormOptionsQuery());

        /**
         * @var CuentaEditDTO
         */
        $cuenta = $this->queryBus->ask(new GetCuentaForEditQuery(id: $id));
        return Inertia::render('Cuentas/Edit', [
            'title' => 'Cuentas',
            'NoRegistros' => $this->NoRegistros(),
            'options' => $options,
            'data' => $cuenta,
            'can_update_saldo' => $cuenta->can_update_saldo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAndUpdateCuentaRequest $request, int $id)
    {
        $command = new UpdateCuentaCommand(
            id: $id,
            nombre: $request->nombre,
            notas: $request->notas,
            saldo_inicial: $request->saldo_inicial,
            saldo_actual: $request->saldo_actual,
            propietario_id: $request->propietario_id,
            tipo_cuenta_id: $request->tipo_cuenta_id,
        );

        $this->dispatcher->dispatch($command);
        Inertia::flash('success', 'Cuenta actualizada correctamente');
        return redirect()->route('cuentas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $command = new DestroyCuentaCommand(
            id: $id,
        );

        $this->dispatcher->dispatch($command);
        Inertia::flash('success', 'Cuenta Archivada correctamente');
        return redirect()->route('cuentas.index');
    }

    public function toggleActive(int $id, string $attribute)
    {
        $this->dispatcher->dispatch(new ToggleCuentaCommand(
            id: $id,
            attribute: $attribute,
        ));

        Inertia::flash('success', 'Cuenta actualizada correctamente');
        return redirect()->route('cuentas.index');
    }
}
