<?php

namespace App\Http\Controllers\Usuario;

use App\Application\Usuario\Commands\ChangePasswordCommand;
use App\Application\Usuario\Commands\UpdatePublicDataCommand;
use App\Application\Usuario\Queries\GetUsuarioForEditQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\ChangePasswordRequest;
use App\Http\Requests\Usuario\UpdatePublicDataRequest;
use App\Shared\Application\Contracts\Bus\QueryBus;
use Illuminate\Contracts\Bus\Dispatcher;
use Inertia\Inertia;

/**
 * Controlador de presentación para la edición del usuario autenticado.
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

    public function edit()
    {
        $usuario = $this->queryBus->ask(new GetUsuarioForEditQuery(
            id: (string) auth()->id(),
        ));

        return Inertia::render('Usuario/Perfil', [
            'title' => 'Usuario',
            'data' => $usuario,
        ]);
    }

    public function updateDatosPublicos(UpdatePublicDataRequest $request)
    {
        $this->dispatcher->dispatch(new UpdatePublicDataCommand(
            id: (string) auth()->id(),
            name: $request->name,
            email: $request->email,
        ));

        Inertia::flash('success', 'Usuario actualizado correctamente');

        return redirect()->route('usuario.edit');
    }

    public function editPassword()
    {
        return Inertia::render('Usuario/Password', [
            'title' => 'Contraseña',
        ]);
    }

    public function cambiarPassword(ChangePasswordRequest $request)
    {
        $this->dispatcher->dispatch(new ChangePasswordCommand(
            id: (string) auth()->id(),
            currentPassword: $request->current_password,
            newPassword: $request->password,
        ));

        Inertia::flash('success', 'Contraseña actualizada correctamente');

        return redirect()->route('usuario.password.edit');
    }
}
