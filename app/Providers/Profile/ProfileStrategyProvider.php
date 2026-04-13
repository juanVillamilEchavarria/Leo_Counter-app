<?php

namespace App\Providers\Profile;

use Illuminate\Support\ServiceProvider;
use App\Domains\Profile\Strategies\Resolvers\UpdateProfileSectionValidateResolver;
use App\Domains\Profile\Contracts\Strategies\UpdateProfileSectionValidateStrategyContract;
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
