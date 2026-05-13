<?php

namespace App\Http\Controllers\Movimiento;

use App\Models\Movimiento\Movimiento;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Events\Dispatcher;
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
use App\Application\Movimiento\Queries\GetEspontaneoMovimientoRecordsCountQuery;
use App\Application\Movimiento\Queries\ListAllSpontaneousMovimientosWithDetailsQuery;
use App\Application\Movimiento\Queries\ListMovimientoFormOptionsQuery;
use App\Application\Movimiento\Queries\GetMovimientoForEditQuery;
use App\Shared\Infrastructure\Framework\Laravel\Builders\LaravelUploadedFileBuilder;

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
            'NoRegistros'=> $this->queryBus->ask(new GetEspontaneoMovimientoRecordsCountQuery()),
        ];
    }
    public function index()
    {
        $props = array_merge($this->props(),[
            'dia'=> Carbon::now()->format('Y-m-d'),
            'movimientos'=>$this->queryBus->ask(new ListAllSpontaneousMovimientosWithDetailsQuery(MovimientoVariants::ESPONTANEO))
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
       $command = new StoreMovimientoCommand(
           nombre: $request->nombre,
           cuenta_id: $request->cuenta_id,
           categoria_id: $request->categoria_id,
           tipo_movimiento_id: $request->tipo_movimiento_id,
           monto: $request->monto,
           descripcion: $request->descripcion,
           comprobantes: $laravelFiles
       );
       $this->dispatcher->dispatch($command);
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
    public function edit(Movimiento $movimientoEspontaneo)
    {

        $props = array_merge($this->props('Editar Movimiento Espontaneo'),[
            'data'=>$this->queryBus->ask(new GetMovimientoForEditQuery($movimientoEspontaneo->id)),
            'options'=> $this->queryBus->ask(new ListMovimientoFormOptionsQuery())
        ]);
        return Inertia::render('Movimientos/Espontaneos/Edit',$props);
    }

    /**
     * Update the specified resource in storage.
     */
   // public function update(UpdateMovimientoEspontaneoRequest $request, Movimiento $movimientoEspontaneo)
    //{

     //   $this->movimientoService->update($movimientoEspontaneo, $request->validated());
    //    Inertia::flash('success','Movimiento actualizado con exito');
      //  return redirect()->route('movimientosEspontaneos.index');
    //}

    /**
     * Remove the specified resource from storage.
     */
    //public function destroy(DestroyMovimientoEspontaneoRequest $request, Movimiento $movimientoEspontaneo )
    //{
     //   $this->movimientoService->destroy($movimientoEspontaneo, $request->validated());
     //   Inertia::flash('success','Movimiento eliminado con exito');
      //  return redirect()->route('movimientosEspontaneos.index');
   // }
}
