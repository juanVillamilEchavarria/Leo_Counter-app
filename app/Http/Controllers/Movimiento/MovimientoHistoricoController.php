<?php

namespace App\Http\Controllers\Movimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovimientoHistoricoController extends Controller
{
    public function index (){
        return Inertia::render('Movimientos/Historicos/Index',[
            'tittle'=>'Movimientos Historicos'
        ]);
    }
}
