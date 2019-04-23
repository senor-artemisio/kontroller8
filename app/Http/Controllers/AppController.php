<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Render SPA.
 */
class AppController
{
    /**
     * @return Factory|View
     */
    public function index(): View
    {
        return view('app');
    }
}