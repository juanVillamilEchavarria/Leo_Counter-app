<?php

namespace App\Application\Profile\Providers\Specifications;

use Illuminate\Support\ServiceProvider;
use App\Domains\Profile\Factories\ProfileDTOFactory;
use App\Domains\Profile\Specifications\Domain\ProfileDTOSpecification;
use App\Domains\Profile\Specifications\Domain\PasswordDTOSpecification;

class ProfileSpecificationProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ProfileDTOFactory::class, function($app){
            return new ProfileDTOFactory([
                $app->make(ProfileDTOSpecification::class),
                $app->make(PasswordDTOSpecification::class)
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
