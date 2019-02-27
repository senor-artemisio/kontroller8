<?php

namespace App\Providers;

use App\Api\Policies\ItemPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Api\Models\Item;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Item::class => ItemPolicy::class,
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
