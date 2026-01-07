<?php

namespace App\Http\Controllers\Presupuesto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PresupuestoHistoricoController extends Controller
{
    public function index(){
        return Inertia::render('Presupuestos/Historicos/Index',[
            'title' => 'Presupuestos',
            'NoRegistros' => 24

        ]);
    }
}
