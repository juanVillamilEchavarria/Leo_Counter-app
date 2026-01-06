<?php

namespace App\Http\Controllers\Movimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Carbon;
class MovimientoMesActualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {  
        // le pasamos la vista con el mes actual formateado a string y a español
        
        return Inertia::render('Movimientos/MesActual/Index',[
            'title' => 'Movimientos Del Mes Actual',
            'NoRegistros' => 14,
            'inicio' => Carbon::now()->startOfMonth()->toISOString(),
            'fin' => Carbon::now()->endOfMonth()->toISOString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
