<?php

namespace App\Api\Http\Controllers;

use App\Api\DTO\DayDTO;
use App\Api\DTO\DTOException;
use App\Api\Http\Requests\DayRequest;
use App\Api\Http\Requests\DaysRequest;
use App\Api\Http\Resources\DayResource;
use App\Api\Models\Day;
use App\Api\Repositories\DayRepository;
use App\Api\Services\DayService;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

/**
 * REST API for days.
 */
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

        $this->dayRepository->paginate($request->getPerPage())
            ->sort($request->getSortBy(), $request->getSortDirection());

        $date = $request->get('date');
        if ($date !== null) {
            $this->dayRepository->filter('date', $date);
        }

        $days = $this->dayRepository->findByOwner($userId);

        return DayResource::collection($days);
    }

    /**
     * @param DayRequest $request
     * @return DayResource
     * @throws AuthorizationException
     * @throws DTOException
     */
    public function store(DayRequest $request): DayResource
    {
        $this->authorize('create', Day::class);

        $dayDTO = new DayDTO($request->all());
        $dayDTO->setId(\Ulid::generate());

        $this->dayService->create($dayDTO, Auth::user()->getAuthIdentifier());

        $createdDay = $this->dayRepository->findById($dayDTO->getId());
        $createdDay->wasRecentlyCreated = true;

        return DayResource::make($createdDay);
    }

    /**
     * @param Day $day
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Day $day): void
    {
        $this->authorize('delete', $day);
        $this->dayService->delete($day);
    }
}