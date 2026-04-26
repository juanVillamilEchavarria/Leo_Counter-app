<?php

namespace App\Http\Controllers\Categoria;

use App\Application\Categoria\Commands\StoreCategoryCommand;
use App\Application\Categoria\Commands\UpdateCategoryCommand;
use App\Application\Categoria\Commands\DestroyCategoryCommand;
use App\Http\Controllers\Controller;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Categoria\Queries\ListAllCategoriesWithDetailsQuery;
use App\Application\Categoria\Queries\ListCategoriesRecordsCountQuery;
use App\Application\Categoria\Queries\ListCategoryFormOptionsQuery;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Http\Requests\Categoria\StoreAndUpdateCategoriaRequest;
use Inertia\Inertia;

class CategoriaController extends Controller
{

    
    public function __construct(
        private QueryBus $queryBus,
        private Dispatcher $dispatcher
        )
    {
    }   


    private function NoRegistros(){
        return $this->queryBus->ask(new ListCategoriesRecordsCountQuery());
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = $this->queryBus->ask(new ListAllCategoriesWithDetailsQuery());
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
        $options = $this->queryBus->ask(new ListCategoryFormOptionsQuery());
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
        $command = new StoreCategoryCommand(
            nombre: $request->nombre,
            tipo_movimiento_id: $request->tipo_movimiento_id,
            descripcion: $request->descripcion
        );
        $this->dispatcher->dispatch($command);
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

    // Pendiente de implementar 
    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(int $id)
    // {
    //     return Inertia::render('Categorias/Edit',[
    //         'title'=>'Editar Categoria',
    //         'NoRegistros'=>$this->NoRegistros(),
    //         'data'=>$categoria,
    //         'options'=>$this->queryBus->ask(new ListCategoryFormOptionsQuery())
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAndUpdateCategoriaRequest $request, int $id)
    {
        $command = new UpdateCategoryCommand(
            id: $id,
            nombre: $request->nombre,
            tipo_movimiento_id: $request->tipo_movimiento_id,
            descripcion: $request->descripcion
        );
        $this->dispatcher->dispatch($command);
        Inertia::flash('success','Categoria actualizada con exito');
        return redirect()->route('categorias.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
            $command = new DestroyCategoryCommand(
                id: $id
        );
        $this->dispatcher->dispatch($command);
        Inertia::flash('success','Categoria eliminada con exito');
        return redirect()->route('categorias.index');
    }

    // public function toggleEsFijo(Categoria $categoria, string $attribute)
    // {
    //     $this->categoriaService->toggleEsFijo($categoria);
    //     Inertia::flash('success','Categoria actualizada con exito');
    //     return redirect()->route('categorias.index');
    // }
}
