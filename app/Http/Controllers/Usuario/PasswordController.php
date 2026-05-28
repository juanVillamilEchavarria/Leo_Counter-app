<?php

namespace App\Http\Controllers\Usuario;

use App\Application\Usuario\Commands\ChangeOwnPasswordCommand;
use App\Application\Usuario\Commands\UpdatePublicDataCommand;
use App\Application\Usuario\Queries\GetUsuarioForEditQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\ChangePasswordRequest;
use App\Http\Requests\Usuario\UpdatePublicDataRequest;
use Illuminate\Http\Request;

use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Shared\Application\Contracts\Bus\CommandBus;
use Inertia\Inertia;

class PasswordController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private CommandBus $commandBus,
    )
    {
    }
    public function index(){
        return Inertia::render('Perfil/Password', [
            'title' => 'Contraseña',
        ]);

    }
    public function update(ChangePasswordRequest $request){
        $this->commandBus->dispatch(new ChangeOwnPasswordCommand(
            id: (string) auth()->id(),
            currentPassword: $request->current_password,
            newPassword: $request->password,
        ));

        Inertia::flash('success', 'Contraseña actualizada correctamente');

        return redirect()->route('profile.password.index');
    }

    //
}
