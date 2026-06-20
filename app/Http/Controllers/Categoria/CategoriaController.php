<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Controllers\Categoria;

use App\Application\Categoria\Commands\StoreCategoriaCommand;
use App\Application\Categoria\Commands\UpdateCategoriaCommand;
use App\Application\Categoria\Commands\DestroyCategoriaCommand;
use App\Http\Controllers\Controller;
use App\Application\Categoria\Queries\GetCategoriaForEditQuery;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Categoria\Queries\ListAllCategoriasWithDetailsQuery;
use App\Application\Categoria\Queries\GetCategoriaRecordsCountQuery;
use App\Application\Categoria\Queries\ListCategoriaFormOptionsQuery;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Application\Categoria\Commands\ToggleCategoriaCommand;
use App\Http\Requests\Categoria\StoreAndUpdateCategoriaRequest;
use App\Http\Resources\Categoria\CategoriaResource;
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
        return $this->queryBus->ask(new GetCategoriaRecordsCountQuery());
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = $this->queryBus->ask(new ListAllCategoriasWithDetailsQuery());
        return Inertia::render('Categorias/Index',[
            'title' => 'Categorias',
            'NoRegistros' => $this->NoRegistros(),
            'categorias'=>CategoriaResource::collection($categorias)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->queryBus->ask(new ListCategoriaFormOptionsQuery());
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
        $command = new StoreCategoriaCommand(
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
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categoria = $this->queryBus->ask(new GetCategoriaForEditQuery(id: $id));
        return Inertia::render('Categorias/Edit',[
            'title'=>'Editar Categoria',
            'NoRegistros'=>$this->NoRegistros(),
            'data'=>$categoria,
            'options'=>$this->queryBus->ask(new ListCategoriaFormOptionsQuery())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAndUpdateCategoriaRequest $request, string $id)
    {
        $command = new UpdateCategoriaCommand(
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
    public function destroy(string $id)
    {
        $command = new DestroyCategoriaCommand(
                id: $id
        );
        $this->dispatcher->dispatch($command);
        Inertia::flash('success','Categoria eliminada con exito');
        return redirect()->route('categorias.index');
    }

    public function toggleEsFijo(string $id, string $attribute)
    {
        $this->dispatcher->dispatch(new ToggleCategoriaCommand(id: $id, attribute: $attribute));
        Inertia::flash('success','Categoria actualizada con exito');
        return redirect()->route('categorias.index');
    }
}
