<?php

namespace App\Http\Controllers\Historial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistorialController extends Controller
{
    public function index(){
        return Inertia::render('Historial/Historial',[
            'title' => 'Historial',
            'NoRegistros' => 24
        ]);
    }
}
