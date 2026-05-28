<?php

namespace App\Http\Controllers\Auth;

use App\Application\Auth\Commands\SendPasswordResetLinkCommand;
use App\Http\Controllers\Controller;
use App\Shared\Application\Contracts\Bus\CommandBus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

/**
 * Controlador para solicitar el envio de un enlace de restablecimiento de contraseña.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Http\Controllers\Auth
 * @since 1.0.0
 * @version 1.0.0
 */
final class SendPasswordResetUrlController extends Controller
{
    /**
     * @param CommandBus $commandBus Bus de comandos de aplicacion.
     */
    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    public function index(){
        return Inertia::render('Auth/ForgotPassword');
    }

    /**
     * Valida el email y despacha la solicitud de enlace sin revelar existencia del usuario.
     *
     * @param Request $request Peticion HTTP.
     * @return RedirectResponse Respuesta generica de exito.
     */
    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $this->commandBus->dispatch(new SendPasswordResetLinkCommand($validated['email']));

        Inertia::flash('success', 'Si el correo existe, recibiras un enlace para restablecer tu contraseña.');

        return back();
    }
}
