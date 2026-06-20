<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Controllers\Auditoria;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

/**
 * Controlador para páginas de Auditoría (solo render Inertia para el listado).
 */
final class AuditoriaController extends Controller
{
    public function index()
    {
        return Inertia::render('Auditorias/Index');
    }
}
