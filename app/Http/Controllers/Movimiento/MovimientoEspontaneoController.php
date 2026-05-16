<?php

namespace App\Http\Controllers\Movimiento;

use App\Http\Resources\Movimiento\EditMovimientoResource;
use App\Models\Movimiento\Movimiento;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Application\Movimiento\Commands\StoreMovimientoCommand;
use App\Shared\Infrastructure\Framework\Laravel\ValueObjects\LaravelUploadedFile;
use App\Http\Requests\MovimientoEspontaneo\StoreMovimientoEspontaneoRequest;
use App\Http\Requests\MovimientoEspontaneo\UpdateMovimientoEspontaneoRequest;
use App\Domains\Movimiento\Enums\MovimientoVariants;
use App\Domains\Movimiento\Enums\ResourceEnum;
use App\Http\Requests\MovimientoEspontaneo\DestroyMovimientoEspontaneoRequest;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Movimiento\Queries\GetSpontaneousMovimientoRecordsCountQuery;
use App\Application\Movimiento\Queries\ListAllSpontaneousMovimientosWithDetailsQuery;
use App\Application\Movimiento\Queries\ListMovimientoFormOptionsQuery;
use App\Application\Movimiento\Queries\GetMovimientoForEditQuery;
use App\Shared\Infrastructure\Framework\Laravel\Builders\LaravelUploadedFileBuilder;
use App\Http\Resources\Movimiento\MovimientoResource;
use App\Application\Movimiento\Commands\UpdateMovimientoCommand;
use App\Application\Movimiento\Commands\DestroyMovimientoCommand;

class MovimientoEspontaneoController extends Controller
{

    public function __construct(
        private QueryBus $queryBus,
        private Dispatcher $dispatcher
    )
    {
    }
    /**
     * Display a listing of the resource.
     */
    protected function props(string $title = 'Movimientos Espontaneos') : array{
        return [
            'title'=> $title,
            'NoRegistros'=> $this->queryBus->ask(new GetSpontaneousMovimientoRecordsCountQuery()),
        ];
    }
    public function index()
    {
        $spontaneous = $this->queryBus->ask(new ListAllSpontaneousMovimientosWithDetailsQuery());
        $props = array_merge($this->props(),[
            'dia'=> Carbon::now()->format('Y-m-d'),
            'movimientos'=>MovimientoResource::collection($spontaneous)
        ]);
        return Inertia::render('Movimientos/Espontaneos/Index',$props);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $props = array_merge($this->props('Crear Movimiento Espontaneo'),[
            'options'=> $this->queryBus->ask(new ListMovimientoFormOptionsQuery())
        ]);
       return Inertia::render('Movimientos/Espontaneos/Create',$props);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovimientoEspontaneoRequest $request)
    {
       $laravelFiles = LaravelUploadedFileBuilder::many($request->file('comprobantes'));

       $this->dispatcher->dispatch(
           new StoreMovimientoCommand(
           nombre: $request->nombre,
           cuenta_id: $request->cuenta_id,
           categoria_id: $request->categoria_id,
           tipo_movimiento_id: $request->tipo_movimiento_id,
           monto: $request->monto,
           descripcion: $request->descripcion,
           comprobantes: $laravelFiles
       )
       );
        Inertia::flash('success','Movimiento creado con exito');
        return redirect()->route('movimientosEspontaneos.index');
    }


    ///**
    // * Display the specified resource.
    // */
 //  ////public function show(string $id)
    //{
        //
    //}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $data = $this->queryBus->ask(new GetMovimientoForEditQuery($id));
        $props = array_merge($this->props('Editar Movimiento Espontaneo'),[
            'data'=> EditMovimientoResource::make($data),
            'options'=> $this->queryBus->ask(new ListMovimientoFormOptionsQuery())
        ]);
        return Inertia::render('Movimientos/Espontaneos/Edit',$props);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovimientoEspontaneoRequest $request, string $id)
    {

        $laravelFiles = LaravelUploadedFileBuilder::many($request->file('comprobantes'));

        $this->dispatcher->dispatch(
            new UpdateMovimientoCommand(
                id: $id,
                nombre: $request->nombre,
                cuenta_id: $request->cuenta_id,
                categoria_id: $request->categoria_id,
                tipo_movimiento_id: $request->tipo_movimiento_id,
                monto: $request->monto,
                descripcion: $request->descripcion,
                comprobantes: $laravelFiles,
                comprobantes_existing: $request->comprobantes_existing,
                comprobantes_delete_ids: $request->comprobantes_delete_ids

            )
        );
        Inertia::flash('success','Movimiento actualizado con exito');
        return redirect()->route('movimientosEspontaneos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyMovimientoEspontaneoRequest $request, string $id )
    {
        $this->dispatcher->dispatch(
            new DestroyMovimientoCommand(
                id: $id,
                attempt_password: $request->password
            )
        );
        Inertia::flash('success','Movimiento eliminado con exito');
        return redirect()->route('movimientosEspontaneos.index');
    }
}
