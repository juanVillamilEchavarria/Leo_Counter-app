<?php

namespace App\Http\Controllers\Movimiento;

use App\Models\Movimiento\Movimiento;
use App\Http\Controllers\Controller;
use App\Application\Movimiento\Services\MovimientoService;
use App\Http\Requests\MovimientoEspontaneo\StoreMovimientoEspontaneoRequest;
use App\Http\Requests\MovimientoEspontaneo\UpdateMovimientoEspontaneoRequest;
use App\Domains\Movimiento\Enums\MovimientoVariants;
use App\Domains\Movimiento\Enums\ResourceEnum;
use App\Http\Requests\MovimientoEspontaneo\DestroyMovimientoEspontaneoRequest;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Movimiento\Queries\GetEspontaneoMovimientoRecordsCountQuery;
use App\Application\Movimiento\Queries\ListAllMovimientoWithDetailsQuery;
use App\Application\Movimiento\Queries\ListMovimientoFormOptionsQuery;
use App\Application\Movimiento\Queries\GetMovimientoForEditQuery;

class MovimientoEspontaneoController extends Controller
{

    public function __construct(
        private MovimientoService $movimientoService,
        private QueryBus $queryBus,
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
            'movimientos'=>$this->queryBus->ask(new ListAllMovimientoWithDetailsQuery(MovimientoVariants::ESPONTANEO))
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
    public function update(UpdateMovimientoEspontaneoRequest $request, Movimiento $movimientoEspontaneo)
    {

        $this->movimientoService->update($movimientoEspontaneo, $request->validated());
        Inertia::flash('success','Movimiento actualizado con exito');
        return redirect()->route('movimientosEspontaneos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyMovimientoEspontaneoRequest $request, Movimiento $movimientoEspontaneo )
    {
        $this->movimientoService->destroy($movimientoEspontaneo, $request->validated());
        Inertia::flash('success','Movimiento eliminado con exito');
        return redirect()->route('movimientosEspontaneos.index');
    }
}
