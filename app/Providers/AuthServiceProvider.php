<?php

namespace App\Providers;

use App\Api\Models\Day;
use App\Api\Policies\DayPolicy;
use App\Api\Policies\MealPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Api\Models\Meal;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Meal::class => MealPolicy::class,
        Day::class => DayPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Passport::routes(function ($router) {
            /** @var \Laravel\Passport\RouteRegistrar $router */
            $router->forAccessTokens();
        }, ['middleware' => ['json']]);
    }
}
