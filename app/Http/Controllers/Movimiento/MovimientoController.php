<?php

namespace App\Http\Controllers\Movimiento;

use App\Application\Movimiento\Queries\GetMovimientoForShowQuery;
use App\Http\Controllers\Controller;
use App\Http\Resources\Movimiento\ShowMovimientoResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Movimiento\Queries\GetMovimientoRecordsCountQuery;

class MovimientoController extends Controller
{

    public function __construct(
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


   public function show(string $id){

        $data =$this->queryBus->ask(new GetMovimientoForShowQuery($id));
    $props = array_merge($this->props(),[
        'data'=> ShowMovimientoResource::make($data)
    ]);

    return Inertia::render('Movimientos/Historicos/Index', $props);

   }
}
