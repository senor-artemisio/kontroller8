<?php

namespace App\Api\Http\Controllers;

use App\Api\Http\Requests\DaysRequest;
use App\Api\Http\Resources\DayResource;
use App\Api\Repositories\DayRepository;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class DayController extends Controller
{
    /** @var DayRepository */
    private $dayRepository;

    public function __construct(DayRepository $dayRepository)
    {
        $this->dayRepository = $dayRepository;
    }

    /**
     * @param DaysRequest $request
     * @return ResourceCollection
     * @throws AuthorizationException
     */
    public function index(DaysRequest $request): ResourceCollection
    {
        $this->authorize('list');
        $date = $request->getDate();
        $userId = Auth::user()->getAuthIdentifier();
        $days = $this->dayRepository->findWeekByOwner($userId, $date);

        return DayResource::collection($days);
    }
}