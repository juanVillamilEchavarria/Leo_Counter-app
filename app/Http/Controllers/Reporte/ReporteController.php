<?php

namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReporteController extends Controller
{
    public function index(){
        return Inertia::render('Reportes/Reporte',[
            'title' => 'Reportes'
        ]);
    }
}
