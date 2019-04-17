<?php

namespace App\Api\Http\Controllers;

use App\Api\Http\Requests\DaysRequest;
use App\Api\Http\Resources\DayResource;
use App\Api\Models\Day;
use App\Api\Repositories\DayRepository;
use App\Api\Services\DayService;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class DayController extends Controller
{
    /** @var DayRepository */
    private $dayRepository;

    /** @var DayService */
    private $dayService;

    /**
     * @param DayRepository $dayRepository
     * @param DayService $dayService
     */
    public function __construct(DayRepository $dayRepository, DayService $dayService)
    {
        $this->dayRepository = $dayRepository;
        $this->dayService = $dayService;
    }

    /**
     * @param DaysRequest $request
     * @return ResourceCollection
     * @throws AuthorizationException
     */
    public function index(DaysRequest $request): ResourceCollection
    {
        $this->authorize('list', Day::class);
        $userId = Auth::user()->getAuthIdentifier();

        $days = $this->dayRepository
            ->paginate($request->getPerPage())
            ->sort($request->getSortBy(), $request->getSortDirection())
            ->findByOwner($userId);

        return DayResource::collection($days);
    }
}