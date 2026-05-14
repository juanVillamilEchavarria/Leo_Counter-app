<?php

namespace App\Http\Controllers\MovimientoPendiente;

use App\Application\MovimientoPendiente\Commands\DestroyMovimientoPendienteCommand;
use App\Application\MovimientoPendiente\Commands\StoreMovimientoPendienteCommand;
use App\Application\MovimientoPendiente\Commands\UpdateMovimientoPendienteCommand;
use App\Application\MovimientoPendiente\Queries\GetMovimientoPendienteForEditQuery;
use App\Application\MovimientoPendiente\Queries\GetMovimientoPendienteRecordsCountQuery;
use App\Application\MovimientoPendiente\Queries\ListAllMovimientoPendienteQuery;
use App\Application\MovimientoPendiente\Queries\ListMovimientoPendienteFormOptionsQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovimientoPendiente\MarkAsDoneRequest;
use App\Http\Requests\MovimientoPendiente\StoreAndUpdateMovimientoPendienteRequest;
use App\Http\Resources\MovimientoPendiente\MovimientoPendienteResource;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Shared\Infrastructure\Framework\Laravel\Builders\LaravelUploadedFileBuilder;
use Illuminate\Contracts\Bus\Dispatcher;
use Inertia\Inertia;
use App\Application\MovimientoPendiente\Commands\MarkAsDoneMovimientoPendienteCommand;

/**
 * Controlador de presentacion para MovimientoPendiente.
 * Coordina requests HTTP con comandos y queries de aplicacion sin acoplarse
 * a Eloquent, servicios legacy ni route model binding.
 *
 * No implementa la funcionalidad de marcar como realizado, que sera
 * abordada en una fase posterior del refactor.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Http\Controllers\MovimientoPendiente
 * @since 1.0.0
 * @version 1.0.0
 */
class MovimientoPendienteController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private Dispatcher $dispatcher,
    ) {
    }

    /**
     * Obtiene el total de registros de movimientos pendientes para las props compartidas.
     *
     * @return int Total de registros pendientes.
     */
    private function NoRegistros(): int
    {
        return $this->queryBus->ask(new GetMovimientoPendienteRecordsCountQuery());
    }

    /**
     * Muestra la lista de movimientos pendientes.
     */
    public function index()
    {
        $movimientos = $this->queryBus->ask(new ListAllMovimientoPendienteQuery());

        return Inertia::render('MovimientosPendientes/Index', [
            'title' => 'Movimientos Pendientes',
            'NoRegistros' => $this->NoRegistros(),
            'movimientos' => MovimientoPendienteResource::collection($movimientos),
        ]);
    }

    /**
     * Muestra el formulario de creacion de movimiento pendiente.
     */
    public function create()
    {
        return Inertia::render('MovimientosPendientes/Create', [
            'title' => 'Crear Movimiento Pendiente',
            'NoRegistros' => $this->NoRegistros(),
            'options' => $this->queryBus->ask(new ListMovimientoPendienteFormOptionsQuery()),
        ]);
    }

    /**
     * Almacena un nuevo movimiento pendiente.
     */
    public function store(StoreAndUpdateMovimientoPendienteRequest $request)
    {
        $this->dispatcher->dispatch(new StoreMovimientoPendienteCommand(
            categoria_id: $request->categoria_id,
            tipo_movimiento_id: (int) $request->tipo_movimiento_id,
            cuenta_id: $request->cuenta_id,
            nombre: $request->nombre,
            monto: (float) $request->monto,
            fecha_programada: $request->fecha_programada,
            dias_aviso: $request->dias_aviso !== null ? (int) $request->dias_aviso : null,
            descripcion: $request->descripcion,
        ));

        Inertia::flash('success', 'Movimiento Pendiente creado con exito');
        return redirect()->route('movimientosPendientes.index');
    }

    /**
     * Muestra el detalle de un movimiento pendiente.
     */
    public function show(string $id)
    {
        $movimientos = $this->queryBus->ask(new ListAllMovimientoPendienteQuery());

        return Inertia::render('MovimientosPendientes/Index', [
            'title' => 'Detalle Movimiento Pendiente',
            'NoRegistros' => $this->NoRegistros(),
            'movimientos' => MovimientoPendienteResource::collection($movimientos),
            'data' => $this->queryBus->ask(new GetMovimientoPendienteForEditQuery(id: $id)),
        ]);
    }

    /**
     * Muestra el formulario de edicion de movimiento pendiente.
     */
    public function edit(string $id)
    {
        return Inertia::render('MovimientosPendientes/Edit', [
            'title' => 'Editar Movimiento Pendiente',
            'NoRegistros' => $this->NoRegistros(),
            'data' => $this->queryBus->ask(new GetMovimientoPendienteForEditQuery(id: $id)),
            'options' => $this->queryBus->ask(new ListMovimientoPendienteFormOptionsQuery()),
        ]);
    }

    /**
     * Actualiza un movimiento pendiente existente.
     */
    public function update(StoreAndUpdateMovimientoPendienteRequest $request, string $id)
    {
        $this->dispatcher->dispatch(new UpdateMovimientoPendienteCommand(
            id: $id,
            categoria_id: $request->categoria_id,
            tipo_movimiento_id: (int) $request->tipo_movimiento_id,
            cuenta_id: $request->cuenta_id,
            nombre: $request->nombre,
            monto: (float) $request->monto,
            fecha_programada: $request->fecha_programada,
            dias_aviso: $request->dias_aviso !== null ? (int) $request->dias_aviso : null,
            descripcion: $request->descripcion,
        ));

        Inertia::flash('success', 'Movimiento Pendiente actualizado con exito');
        return redirect()->route('movimientosPendientes.index');
    }

    public function markAsDone(MarkAsDoneRequest $request, string $id){
        $this->dispatcher->dispatch(new MarkAsDoneMovimientoPendienteCommand(
            id: $id,
            comprobantes: LaravelUploadedFileBuilder::many($request->file('comprobantes'))
        ));

        Inertia::flash('success', 'Movimiento Pendiente marcado como realizado con exito');
        return redirect()->route('movimientosPendientes.index');

    }
    /**
     * Elimina (soft delete) un movimiento pendiente.
     */
    public function destroy(string $id)
    {
        $this->dispatcher->dispatch(new DestroyMovimientoPendienteCommand(id: $id));

        Inertia::flash('success', 'Movimiento Pendiente eliminado con exito');
        return redirect()->route('movimientosPendientes.index');
    }
}
