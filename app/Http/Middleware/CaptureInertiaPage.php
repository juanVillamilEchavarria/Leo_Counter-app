<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

/**
 * Captura la página actual de Inertia para poder recuperarla si ocurre una excepción.
 */
class CaptureInertiaPage
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->headers->get('x-inertia') && $request->route()) {
            session()->put('_inertia_page', [
                'component' => $request->route()->defaults['component'] ?? null,
                'props' => Inertia::getShared(),
            ]);
        }

        return $response;
    }
}
