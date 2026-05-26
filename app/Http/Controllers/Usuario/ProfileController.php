<?php

namespace App\Http\Controllers\Usuario;

use App\Application\Usuario\Commands\UpdatePublicDataCommand;
use App\Application\Usuario\Queries\GetUsuarioForEditQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\UpdatePublicDataRequest;
use Illuminate\Http\Request;

use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Shared\Application\Contracts\Bus\CommandBus;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private CommandBus $commandBus,
    )
    {
    }
    public function index(){
        $usuario = $this->queryBus->ask(new GetUsuarioForEditQuery(
            id: (string) auth()->id(),
        ));

        return Inertia::render('Perfil/Perfil', [
            'title' => 'Perfil',
            'data' => $usuario,
        ]);

    }
    public function update(UpdatePublicDataRequest $request){
        $this->commandBus->dispatch(new UpdatePublicDataCommand(
            id: (string) auth()->id(),
            name: $request->name,
            email: $request->email,
        ));

        Inertia::flash('success', 'Usuario actualizado correctamente');

        return redirect()->route('profile.index');
    }
    //
}
