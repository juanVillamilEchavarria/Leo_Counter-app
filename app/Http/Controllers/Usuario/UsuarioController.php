<?php

namespace App\Http\Controllers\Usuario;

use App\Application\Usuario\Commands\ChangeUserPasswordCommand;
use App\Application\Usuario\Commands\DestroyUsuarioCommand;
use App\Application\Usuario\Commands\StoreUsuarioCommand;
use App\Application\Usuario\Commands\UpdatePublicDataCommand;
use App\Application\Usuario\Queries\GetUsuarioForEditQuery;
use App\Application\Usuario\Queries\ListAllUsuariosQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\ChangeUserPasswordRequest;
use App\Http\Requests\Usuario\StoreUsuarioRequest;
use App\Http\Requests\Usuario\UpdateUsuarioRequest;
use App\Shared\Application\Contracts\Bus\QueryBus;
use Illuminate\Contracts\Bus\Dispatcher;
use Inertia\Inertia;

/**
 * Controlador resource para la administración de usuarios.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Http\Controllers\Usuario
 * @since 1.0.0
 * @version 1.0.0
 */
final class UsuarioController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private Dispatcher $dispatcher,
    ) {
    }

    public function index()
    {
        $usuarios = $this->queryBus->ask(new ListAllUsuariosQuery());

        return Inertia::render('Usuarios/Index', [
            'title' => 'Usuarios',
            'NoRegistros' => $usuarios->count(),
            'usuarios' => $usuarios,
        ]);
    }

    public function create()
    {
        return Inertia::render('Usuarios/Create', [
            'title' => 'Crear Usuario',
            'NoRegistros' => $this->queryBus->ask(new ListAllUsuariosQuery())->count(),
        ]);
    }

    public function store(StoreUsuarioRequest $request)
    {
        $this->dispatcher->dispatch(new StoreUsuarioCommand(
            name: $request->name,
            email: $request->email,
            password: $request->password,
        ));

        Inertia::flash('success', 'Usuario creado con exito');
        return redirect()->route('usuarios.index');
    }

    public function show(string $id)
    {
        return redirect()->route('usuarios.edit', $id);
    }

    public function edit(string $id)
    {
        $usuario = $this->queryBus->ask(new GetUsuarioForEditQuery(id: $id));

        return Inertia::render('Usuarios/Edit', [
            'title' => 'Editar Usuario',
            'NoRegistros' => $this->queryBus->ask(new ListAllUsuariosQuery())->count(),
            'data' => $usuario,
        ]);
    }

    public function update(UpdateUsuarioRequest $request, string $id)
    {
        $this->dispatcher->dispatch(new UpdatePublicDataCommand(
            id: $id,
            name: $request->name,
            email: $request->email,
        ));

        Inertia::flash('success', 'Usuario actualizado con exito');
        return redirect()->route('usuarios.index');
    }

    public function changePassword(ChangeUserPasswordRequest $request, string $id)
    {
        $this->dispatcher->dispatch(new ChangeUserPasswordCommand(
            id: $id,
            newPassword: $request->password,
        ));

        Inertia::flash('success', 'Contraseña actualizada con exito');
        return redirect()->route('usuarios.index');
    }

    public function destroy(string $id)
    {
        $this->dispatcher->dispatch(new DestroyUsuarioCommand(id: $id));

        Inertia::flash('success', 'Usuario eliminado con exito');
        return redirect()->route('usuarios.index');
    }
}
