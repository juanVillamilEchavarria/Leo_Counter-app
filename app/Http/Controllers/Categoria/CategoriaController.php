<?php

namespace App\Http\Controllers\Categoria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Categoria\Services\CategoriaService;
use App\Http\Requests\Categoria\StoreAndUpdateCategoriaRequest;
use App\Models\Categoria\Categoria;
use Inertia\Inertia;

class CategoriaController extends Controller
{

    
    public function __construct(private CategoriaService $categoriaService)
    {
    }   


    private function NoRegistros(){
        return $this->categoriaService->getRecordsCount();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = $this->categoriaService->getAllWithDetails();
        return Inertia::render('Categorias/Index',[
            'title' => 'Categorias',
            'NoRegistros' => $this->NoRegistros(),
            'categorias'=>$categorias
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->categoriaService->getOptions();
        return Inertia::render('Categorias/Create',[
            'title'=>'Crear Categoria',
            'NoRegistros'=>$this->NoRegistros(),
            'options'=>$options
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAndUpdateCategoriaRequest $request)
    {
        $this->categoriaService->store($request->validated());
        Inertia::flash('success','Categoria creada con exito');
        return redirect()->route('categorias.index');
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
    public function edit(Categoria $categoria)
    {
        return Inertia::render('Categorias/Edit',[
            'title'=>'Editar Categoria',
            'NoRegistros'=>$this->NoRegistros(),
            'data'=>$categoria,
            'options'=>$this->categoriaService->getOptions()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAndUpdateCategoriaRequest $request, Categoria $categoria)
    {
        $this->categoriaService->update($categoria, $request->validated());
        Inertia::flash('success','Categoria actualizada con exito');
        return redirect()->route('categorias.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $this->categoriaService->destroy($categoria);
        Inertia::flash('success','Categoria eliminada con exito');
        return redirect()->route('categorias.index');
    }

    public function toggleEsFijo(Categoria $categoria, string $attribute)
    {
        $this->categoriaService->toggleEsFijo($categoria);
        Inertia::flash('success','Categoria actualizada con exito');
        return redirect()->route('categorias.index');
    }
}
