<?php

namespace App\Domains\Profile\Strategies\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Profile\Strategies\Resolvers\UpdateProfileSectionValidateResolver;
use App\Domains\Profile\Strategies\Contracts\UpdateProfileSectionValidateStrategyContract;
use App\Domains\Profile\Strategies\Domain\NameAndEmailProfileSectionValidateStrategy;
use App\Domains\Profile\Strategies\Domain\PasswordProfileSectionValidateStrategy;

class ProfileStrategyProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UpdateProfileSectionValidateResolver::class, function($app){
            return new UpdateProfileSectionValidateResolver([
                $app->make(NameAndEmailProfileSectionValidateStrategy::class),
                $app->make(PasswordProfileSectionValidateStrategy::class)
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
