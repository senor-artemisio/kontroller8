<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Render SPA.
 */
class AppController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function index(): View
    {
        return view('app');
    }
}