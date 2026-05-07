<?php

namespace App\Http\Controllers\Presupuesto;

use App\Application\Categoria\Commands\DestroyCategoryCommand;
use App\Application\Presupuesto\Commands\DestroyPresupuestoCommand;
use App\Application\Presupuesto\Commands\DuplicatePresupuestoCommand;
use App\Application\Presupuesto\Commands\StorePresupuestoCommand;
use App\Application\Presupuesto\Commands\UpdatePresupuestoCommand;
use App\Application\Presupuesto\Services\PresupuestoService;
use App\Http\Requests\Presupuesto\StoreAndUpdatePresupuestoMesActualRequest;
use App\Http\Controllers\Controller;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Presupuesto\Queries\GetCurrentMonthPresupuestosRecordsCountQuery;
use App\Application\Presupuesto\Queries\GetPresupuestoForEditQuery;
use App\Application\Presupuesto\Queries\ListAllCurrentMonthPresupuestosQuery;
use App\Application\Presupuesto\Queries\ListPresupuestoFormOptionsQuery;
use App\Domains\Presupuesto\Aggregates\Presupuesto;
use App\Application\Presupuesto\DTOs\PresupuestoEditDTO;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Contracts\Bus\Dispatcher;

use App\Domains\Presupuesto\Enums\PresupuestoVariants;
use App\Http\Resources\Presupuesto\PresupuestoMesActualResource;

class PresupuestoMesActualController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private Dispatcher $dispatcher
    ) {
    }

    private function NoRegistros()
    {
        return $this->queryBus->ask(new GetCurrentMonthPresupuestosRecordsCountQuery());
    }

    public function index()
    {
        $presupuestos = $this->queryBus->ask(new ListAllCurrentMonthPresupuestosQuery());

        return Inertia::render('Presupuestos/MesActual/Index', [
            'title' => 'Presupuestos del mes',
            'NoRegistros' => $this->NoRegistros(),
            'periodo' => Carbon::now()->firstOfMonth(),
            'presupuestos' =>PresupuestoMesActualResource::collection($presupuestos)
        ]);
    }

    public function create()
    {
        return Inertia::render('Presupuestos/MesActual/Create', [
            'title' => 'Crear presupuesto',
            'NoRegistros' => $this->NoRegistros(),
            'options' => $this->queryBus->ask(new ListPresupuestoFormOptionsQuery()),
            'fechaInicio' => Carbon::now()->firstOfMonth(),
            'fechaFin' => Carbon::now()->lastOfMonth()
        ]);
    }

    public function store(StoreAndUpdatePresupuestoMesActualRequest $request)
    {
        $command = new StorePresupuestoCommand(
            categoria_id: $request->categoria_id,
            monto: $request->monto,
            descripcion: $request->descripcion,
            user_id: auth()->user()->id,
        );
        $this->dispatcher->dispatch($command);
        Inertia::flash('success', 'Presupuesto creado con exito');
        return redirect()->route('presupuestosMesActual.index');
    }

    public function edit(string $id)
    {
        /**
         * @var Presupuesto $presupuesto
         */

        $presupuesto = $this->queryBus->ask(new GetPresupuestoForEditQuery(id: $id));


        return Inertia::render('Presupuestos/MesActual/Edit', [
            'title' => 'Editar presupuesto',
            'NoRegistros' => $this->NoRegistros(),
            'data' => $presupuesto,
            'options' => $this->queryBus->ask(new ListPresupuestoFormOptionsQuery())
        ]);
    }

    public function update(StoreAndUpdatePresupuestoMesActualRequest $request, string $id)
    {
        $command = new UpdatePresupuestoCommand(
            id: $id,
            categoria_id: $request->categoria_id,
            monto: $request->monto,
            descripcion: $request->descripcion,
        );
        $this->dispatcher->dispatch($command);
        Inertia::flash('success', 'Presupuesto actualizado con exito');
        return redirect()->route('presupuestosMesActual.index');
    }

    public function destroy(string $id)
    {
        $this->dispatcher->dispatch(new DestroyPresupuestoCommand(id: $id));
        Inertia::flash('success', 'Presupuesto eliminado con exito');
        return redirect()->route('presupuestosMesActual.index');
    }
    public function duplicate(string $id){
        $this->dispatcher->dispatch(new DuplicatePresupuestoCommand(
            id: $id));
        Inertia::flash('success', 'Presupuesto duplicado con exito');
        return redirect()->route('presupuestosMesActual.index');
    }
}
