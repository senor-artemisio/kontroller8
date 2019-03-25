<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('ratio', function ($attribute, $value, $parameters, $validator) {
            $values = $validator->getData();

            $total = (int)$values['protein'] + (int)$values['fat'] + (int)$values['carbohydrates'];

            return $total <= 100;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
