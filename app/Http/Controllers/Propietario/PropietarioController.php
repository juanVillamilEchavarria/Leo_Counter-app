<?php

namespace App\Http\Controllers\Propietario;

use App\Http\Controllers\Controller;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Propietario\Commands\StorePropietarioCommand;
use App\Application\Propietario\Commands\UpdatePropietarioCommand;
use App\Application\Propietario\Commands\DestroyPropietarioCommand;
use App\Application\Propietario\Queries\ListAllPropietariosWithDetailsQuery;
use App\Application\Propietario\Queries\GetPropietariosRecordsCountQuery;
use App\Application\Propietario\Queries\GetPropietarioForEditQuery;
use App\Application\Propietario\Queries\GetPropietarioForShowQuery;
use App\Http\Requests\Propietario\StoreAndUpdatePropietarioRequest;
use App\Http\Resources\Propietario\PropietarioResource;
use App\Application\Propietario\Contracts\Queries\Executors\GetNumberOfCuentasForPropietarioQueryExecutorContract;
use Illuminate\Contracts\Bus\Dispatcher;
use Inertia\Inertia;

class PropietarioController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private Dispatcher $dispatcher,
    ) {}

    protected function props(string $title = 'Propietarios'): array
    {
        return [
            'title' => $title,
            'NoRegistros' => $this->queryBus->ask(new GetPropietariosRecordsCountQuery()),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propietarios = $this->queryBus->ask(new ListAllPropietariosWithDetailsQuery());

        return Inertia::render('Propietarios/Index', array_merge($this->props(), [
            'propietarios' => PropietarioResource::collection(
                resource:$propietarios)
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Propietarios/Create', $this->props('Crear Propietario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAndUpdatePropietarioRequest $request)
    {
        $this->dispatcher->dispatch(new StorePropietarioCommand(
            nombre: $request->nombre,
            apellido: $request->apellido,
            telefono: $request->telefono,
            email: $request->email,
        ));

        Inertia::flash('success', 'Propietario creado con éxito');
        return redirect()->route('propietarios.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $propietario = $this->queryBus->ask(new GetPropietarioForShowQuery(id: $id));

        return Inertia::render('Propietarios/Index', array_merge($this->props('Detalle Propietario'), [
            'propietarios' => $this->queryBus->ask(new ListAllPropietariosWithDetailsQuery()),
            'data' => $propietario,
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $propietario = $this->queryBus->ask(new GetPropietarioForEditQuery(id: $id));

        return Inertia::render('Propietarios/Edit', array_merge($this->props('Editar Propietario'), [
            'data' => $propietario,
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAndUpdatePropietarioRequest $request, int $id)
    {
        $this->dispatcher->dispatch(new UpdatePropietarioCommand(
            id: $id,
            nombre: $request->nombre,
            apellido: $request->apellido,
            telefono: $request->telefono,
            email: $request->email,
        ));

        Inertia::flash('success', 'Propietario actualizado con éxito');
        return redirect()->route('propietarios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->dispatcher->dispatch(new DestroyPropietarioCommand(id: $id));
        Inertia::flash('success', 'Propietario eliminado con éxito');
        return redirect()->route('propietarios.index');
    }
}
