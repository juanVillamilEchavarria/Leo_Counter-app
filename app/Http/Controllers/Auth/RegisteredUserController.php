<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Application\Usuario\Commands\CreateTheAdminUserCommand;
use App\Http\Requests\Auth\RegisterAdminUserRequest;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    public function __construct(
        private CommandBus $commandBus
    )
    {
    }

    public function index(){
        return Inertia::render('Auth/Register');
    }
    public function store(RegisterAdminUserRequest $request){
        $this->commandBus->dispatch(new CreateTheAdminUserCommand(
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password')
        ));

        Inertia::flash('succes', 'Administrador creado correctamente');

        return redirect()->route('login');

    }
}
