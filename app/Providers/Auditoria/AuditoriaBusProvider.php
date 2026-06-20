<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Auditoria;

use Illuminate\Support\ServiceProvider;

/**
 * Provider placeholder para registrar handlers de bus si se requieren en el futuro.
 */
final class AuditoriaBusProvider extends ServiceProvider
{
    public function register(): void
    {
        // Por ahora no hay bindings específicos para el bus
    }

    public function boot(): void
    {
        //
    }
}
