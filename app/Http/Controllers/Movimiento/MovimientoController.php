<?php

namespace App\Http\Controllers\Movimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovimientoController extends Controller
{
   public function index(){
    return Inertia::render('Movimientos/Movimiento',[
        'title'=>'Movimientos',
        'NoRegistros'=>10

    ]);
   }
}
