<?php

namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(){
        return Inertia::render('Reportes/Reporte',[
            'title' => 'Reportes'
        ]);
    }
    public function download(Request $request){
        dd($request->all());

    }
}
