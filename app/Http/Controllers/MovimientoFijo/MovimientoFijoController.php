<?php

namespace App\Http\Controllers\MovimientoFijo;

use App\Application\MovimientoFijo\Commands\DestroyMovimientoFijoCommand;
use App\Application\MovimientoFijo\Commands\StoreMovimientoFijoCommand;
use App\Application\MovimientoFijo\Commands\ToggleMovimientoFijoCommand;
use App\Application\MovimientoFijo\Commands\UpdateMovimientoFijoCommand;
use App\Application\MovimientoFijo\Queries\GetMovimientoFijoForEditQuery;
use App\Application\MovimientoFijo\Queries\GetMovimientoFijoRecordsCountQuery;
use App\Application\MovimientoFijo\Queries\ListAllMovimientoFijoQuery;
use App\Application\MovimientoFijo\Queries\ListMovimientoFijoFormOptionsQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovimientoFijo\StoreAndUpdateMovimientoFijoRequest;
use App\Http\Resources\MovimientoFijo\MovimientoFijoResource;
use App\Shared\Application\Contracts\Bus\QueryBus;
use Illuminate\Contracts\Bus\Dispatcher;
use Inertia\Inertia;

/**
 * Controlador de presentacion para MovimientoFijo.
 * Coordina requests HTTP con comandos y queries de aplicacion sin acoplarse a Eloquent ni a servicios legacy.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Http\Controllers\MovimientoFijo
 * @since 1.0.0
 * @version 1.0.0
 */
class MovimientoFijoController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private Dispatcher $dispatcher,
    ) {
    }

    private function NoRegistros(): int
    {
        return $this->queryBus->ask(new GetMovimientoFijoRecordsCountQuery());
    }

    public function index()
    {
        $movimientos = $this->queryBus->ask(new ListAllMovimientoFijoQuery());

        return Inertia::render('MovimientosFijos/Index', [
            'title' => 'Movimientos Fijos',
            'NoRegistros'=> $this->NoRegistros(),
            'movimientos' => MovimientoFijoResource::collection($movimientos),
        ]);
    }

    public function create()
    {
        return Inertia::render('MovimientosFijos/Create', [
            'title' => 'Crear Movimiento Fijo',
            'NoRegistros'=> $this->NoRegistros(),
            'options' => $this->queryBus->ask(new ListMovimientoFijoFormOptionsQuery()),
        ]);
    }

    public function store(StoreAndUpdateMovimientoFijoRequest $request)
    {
        $this->dispatcher->dispatch(new StoreMovimientoFijoCommand(
            categoria_id: $request->categoria_id,
            tipo_movimiento_id: (int) $request->tipo_movimiento_id,
            cuenta_id: $request->cuenta_id,
            frecuencia_movimiento_id: (int) $request->frecuencia_movimiento_id,
            nombre: $request->nombre,
            monto: (float) $request->monto,
            fecha_proximo: $request->fecha_proximo,
            dias_aviso: $request->dias_aviso !== null ? (int) $request->dias_aviso : null,
            descripcion: $request->descripcion,
        ));

        Inertia::flash('success','Movimiento Fijo creado con exito');
        return redirect()->route('movimientosFijos.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        return Inertia::render('MovimientosFijos/Edit', [
            'title' => 'Editar Movimiento Fijo',
            'NoRegistros'=> $this->NoRegistros(),
            'data' => $this->queryBus->ask(new GetMovimientoFijoForEditQuery(id: $id)),
            'options' => $this->queryBus->ask(new ListMovimientoFijoFormOptionsQuery()),
        ]);
    }

    public function update(StoreAndUpdateMovimientoFijoRequest $request, string $id)
    {
        $this->dispatcher->dispatch(new UpdateMovimientoFijoCommand(
            id: $id,
            categoria_id: $request->categoria_id,
            tipo_movimiento_id: (int) $request->tipo_movimiento_id,
            cuenta_id: $request->cuenta_id,
            frecuencia_movimiento_id: (int) $request->frecuencia_movimiento_id,
            nombre: $request->nombre,
            monto: (float) $request->monto,
            fecha_proximo: $request->fecha_proximo,
            dias_aviso: $request->dias_aviso !== null ? (int) $request->dias_aviso : null,
            descripcion: $request->descripcion,
        ));

        Inertia::flash('success','Movimiento Fijo actualizado con exito');
        return redirect()->route('movimientosFijos.index');
    }

    public function destroy(string $id)
    {
        $this->dispatcher->dispatch(new DestroyMovimientoFijoCommand(id: $id));

        Inertia::flash('success','Movimiento Fijo eliminado con exito');
        return redirect()->route('movimientosFijos.index');
    }

    public function toggle(string $id, string $attribute)
    {
        $this->dispatcher->dispatch(new ToggleMovimientoFijoCommand(id: $id, attribute: $attribute));

        Inertia::flash('success', 'Movimiento Fijo actualizado correctamente');
        return redirect()->route('movimientosFijos.index');
    }
}
