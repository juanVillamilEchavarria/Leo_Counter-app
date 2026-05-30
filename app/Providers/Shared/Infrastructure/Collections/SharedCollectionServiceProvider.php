<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Shared\Infrastructure\Collections;

use Illuminate\Support\ServiceProvider;

/**
 * Service Provider que registra la implementación base de colecciones
 * del dominio usando Laravel Collection como adapter.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
class SharedCollectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // LaravelCollection es concreta y puede instanciarse directamente
        // No se necesita binding específico aquí
    }
}