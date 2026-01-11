<?php

namespace App\Http\Controllers\Propietario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Propietario\Services\PropietarioService;
use Inertia\Inertia;

class PropietarioController extends Controller
{
    public function __construct(
        private PropietarioService $propietarioService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propietarios = $this->propietarioService->getAll();
        return Inertia::render('Propietarios/Index',[
            'title' => 'Propietarios',
            'NoRegistros' => 24,
            'propietarios' => $propietarios
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
