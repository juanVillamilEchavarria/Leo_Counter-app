<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ConfiguracionController extends Controller
{
    public function index(){

        return Inertia::render('Configuracion/Index',[
            'title' => 'Configuración'
        ]);
    }
}
