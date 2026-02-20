<?php

namespace App\Http\Controllers\Movimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Domains\Movimiento\Service\Application\MovimientoService;
use App\Models\Movimiento\Movimiento;

class MovimientoController extends Controller
{

    public function __construct(
        private MovimientoService $movimientoService
    )
    {
    }

    protected function props (): array{
        return [
            'title'=>'Movimientos',
            'NoRegistros'=>$this->movimientoService->getRecordsCount(),

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
