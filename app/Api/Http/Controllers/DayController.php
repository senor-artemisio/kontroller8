<?php

namespace App\Api\Http\Controllers;

use App\Api\Http\Requests\WeekRequest;
use App\Http\Controllers\Controller;

class DayController extends Controller
{
    /**
     * @param WeekRequest $request
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function week(WeekRequest $request)
    {
        $this->authorize('index');

        $date = $request->get('date');



    }
}