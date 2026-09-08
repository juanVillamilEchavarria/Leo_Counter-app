<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.1.0
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Shared\Application\Contracts\Services\AuthServiceContract;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

/**
 * Controller de autenticación.
 * El rate limiting se maneja a nivel de middleware en la ruta, no aquí.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.0.0
 *
 * @version 1.1.0
 */
class LoginController extends Controller
{
    public function __construct(
        private AuthServiceContract $authService,
    ) {}

    public function index()
    {
        return Inertia::render('Auth/Login');
    }

    public function login(LoginRequest $request)
    {
        if (! $this->authService->login($request->validated(), $request->remember())) {
            Inertia::flash('error', 'Credenciales incorrectas.');

            return back();
        }

        return redirect()->route('home', ['user' => Auth::user()->name]);
    }

    public function logout()
    {
        $this->authService->logout();

        return redirect()->route('login');
    }
}
