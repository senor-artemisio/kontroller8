<?php

namespace App\Api\Http\Controllers;

use App\Api\DTO\DTOException;
use App\Api\DTO\PortionDTO;
use App\Api\Http\Requests\PortionRequest;
use App\Api\Http\Requests\PortionsRequest;
use App\Api\Http\Resources\PortionResource;
use App\Api\Models\Day;
use App\Api\Models\Portion;
use App\Api\Repositories\DayRepository;
use App\Api\Repositories\PortionRepository;
use App\Api\Services\DayService;
use App\Api\Services\PortionService;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class PortionController extends Controller
{
    /** @var PortionRepository */
    private $portionRepository;

    /** @var PortionService */
    private $portionService;

    /** @var DayService */
    private $dayService;

    /** @var DayRepository */
    private $dayRepository;

    /**
     * @param PortionService $portionService
     * @param PortionRepository $portionRepository
     * @param DayService $dayService
     * @param DayRepository $dayRepository
     */
    public function __construct(
        PortionService $portionService,
        PortionRepository $portionRepository,
        DayService $dayService,
        DayRepository $dayRepository
    )
    {
        $this->portionRepository = $portionRepository;
        $this->portionService = $portionService;
        $this->dayService = $dayService;
        $this->dayRepository = $dayRepository;
    }

    /**
     * @param PortionsRequest $request
     * @param Day $day
     * @return ResourceCollection
     * @throws AuthorizationException
     */
    public function index(PortionsRequest $request, Day $day): ResourceCollection
    {
        $this->authorize('view', $day);

        $portions = $this->portionRepository
            ->paginate($request->getPerPage())
            ->sort($request->getSortBy(), $request->getSortDirection())
            ->findByDay($day->id);

        return PortionResource::collection($portions);
    }

    /**
     * @param PortionRequest $request
     * @param Day $day
     * @return PortionResource
     * @throws AuthorizationException
     * @throws DTOException
     */
    public function store(PortionRequest $request, Day $day): PortionResource
    {
        $this->authorize('create', Portion::class);
        $this->authorize('update', $day);

        $dto = new PortionDTO($request->all());
        $dto->setId(\Ulid::generate());

        $this->portionService->create($dto, Auth::user()->getAuthIdentifier(), $day->id);

        $portion = $this->portionRepository->findById($dto->getId());
        $portion->wasRecentlyCreated = true;

        return PortionResource::make($portion);
    }
}