<?php

namespace App\Providers;

use App\Api\Models\Day;
use App\Api\Models\Portion;
use App\Api\Models\Profile;
use App\Api\Policies\DayPolicy;
use App\Api\Policies\MealPolicy;
use App\Api\Policies\PortionPolicy;
use App\Api\Policies\ProfilePolicy;
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
        Portion::class => PortionPolicy::class,
        Profile::class => ProfilePolicy::class
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
