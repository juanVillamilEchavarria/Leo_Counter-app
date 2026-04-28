<?php

namespace App\Providers\Categoria;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Bus;
use App\Application\Categoria\Commands\StoreCategoryCommand;
use App\Application\Categoria\Commands\UpdateCategoryCommand;
use App\Application\Categoria\Commands\DestroyCategoryCommand;
use App\Application\Categoria\Commands\Handlers\StoreCategoryHandler;
use App\Application\Categoria\Commands\Handlers\UpdateCategoryHandler;
use App\Application\Categoria\Commands\Handlers\DestroyCategoryHandler;
use App\Application\Categoria\Commands\Handlers\ToggleCategoryHandler;
use App\Application\Categoria\Commands\ToggleCategoryCommand;

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
            StoreCategoryCommand::class => StoreCategoryHandler::class,
            UpdateCategoryCommand::class => UpdateCategoryHandler::class,
            DestroyCategoryCommand::class => DestroyCategoryHandler::class,
            ToggleCategoryCommand::class => ToggleCategoryHandler::class
        ]);
        
    }
}
