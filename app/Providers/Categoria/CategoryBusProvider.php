<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Categoria;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Bus;
use App\Application\Categoria\Commands\StoreCategoriaCommand;
use App\Application\Categoria\Commands\UpdateCategoriaCommand;
use App\Application\Categoria\Commands\DestroyCategoriaCommand;
use App\Application\Categoria\Commands\Handlers\StoreCategoriaHandler;
use App\Application\Categoria\Commands\Handlers\UpdateCategoriaHandler;
use App\Application\Categoria\Commands\Handlers\DestroyCategoriaHandler;
use App\Application\Categoria\Commands\Handlers\ToggleCategoriaHandler;
use App\Application\Categoria\Commands\ToggleCategoriaCommand;

class CategoryBusProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         Bus::map([
            StoreCategoriaCommand::class => StoreCategoriaHandler::class,
            UpdateCategoriaCommand::class => UpdateCategoriaHandler::class,
            DestroyCategoriaCommand::class => DestroyCategoriaHandler::class,
            ToggleCategoriaCommand::class => ToggleCategoriaHandler::class
        ]);

    }
}
