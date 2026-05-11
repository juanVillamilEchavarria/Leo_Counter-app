<?php

namespace App\Http\Controllers\Movimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Application\Movimiento\Services\MovimientoService;
use App\Models\Movimiento\Movimiento;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Movimiento\Queries\GetMovimientoRecordsCountQuery;

class MovimientoController extends Controller
{

    public function __construct(
        private MovimientoService $movimientoService,
        private QueryBus $queryBus
    )
    {
    }

    protected function props (): array{
        return [
            'title'=>'Movimientos',
            'NoRegistros'=>$this->queryBus->ask(new GetMovimientoRecordsCountQuery()),

        ];
    }
   public function index(){
    return Inertia::render('Movimientos/Historicos/Index',$this->props());
   }


   public function show(Movimiento $movimiento){
    
    $props = array_merge($this->props(),[
        'data'=>$this->movimientoService->getWithDetails($movimiento)
    ]);

    return Inertia::render('Movimientos/Historicos/Index', $props);

   }
}
