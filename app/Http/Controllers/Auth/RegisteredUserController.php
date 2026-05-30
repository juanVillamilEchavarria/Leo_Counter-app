<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
        Inertia::flash('success', 'Administrador creado correctamente');
        return redirect()->route('login');

    }
}
