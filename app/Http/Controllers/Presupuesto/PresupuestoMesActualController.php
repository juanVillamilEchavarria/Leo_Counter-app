<?php

namespace App\Http\Controllers\Presupuesto;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
class PresupuestoMesActualController extends Controller
{
    public function index(){
        return Inertia::render('Presupuestos/MesActual/Index',[
            'title' => 'Presupuestos del mes',
            'NoRegistros' => 24,
            'fechaInicio'=> Carbon::now()->firstOfMonth(),
            'fechaFin'=> Carbon::now()->lastOfMonth()

        ]);

    }
}
