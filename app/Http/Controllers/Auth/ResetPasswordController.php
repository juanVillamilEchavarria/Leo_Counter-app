<?php

namespace App\Http\Controllers\Auth;

use App\Application\Auth\Commands\ResetPasswordCommand;
use App\Application\Auth\Exceptions\InvalidPasswordResetTokenException;
use App\Http\Controllers\Controller;
use App\Shared\Application\Contracts\Bus\CommandBus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

/**
 * Controlador para restablecer una contraseña con token.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Http\Controllers\Auth
 * @since 1.0.0
 * @version 1.0.0
 */
final class ResetPasswordController extends Controller
{
    /**
     * @param CommandBus $commandBus Bus de comandos de aplicacion.
     */
    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    public function index(string $email, string $token){
        return Inertia::render('Auth/ResetPassword', [
            'email' => $email,
            'token' => $token,
        ]);
    }

    /**
     * Valida los datos y despacha el comando de restablecimiento.
     *
     * @param Request $request Peticion HTTP.
     * @return RedirectResponse Redireccion al login cuando el restablecimiento es exitoso.
     */
    public function reset(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

$this->commandBus->dispatch(new ResetPasswordCommand(
                email: $validated['email'],
                token: $validated['token'],
                password: $validated['password']
            ));

        Inertia::flash('success', 'Tu contraseña fue restablecida correctamente.');
        return redirect()->route('login');
    }
}
