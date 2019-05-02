<?php

namespace App\Api\Http\Controllers;

use App\Api\DTO\DTOException;
use App\Api\DTO\MealDTO;
use App\Api\DTO\PortionDTO;
use App\Api\Http\Requests\PortionRequest;
use App\Api\Http\Requests\PortionsRequest;
use App\Api\Http\Resources\PortionResource;
use App\Api\Models\Day;
use App\Api\Models\Portion;
use App\Api\Repositories\MealRepository;
use App\Api\Repositories\PortionRepository;
use App\Api\Services\DayService;
use App\Api\Services\PortionService;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

/**
 * REST API for portions.
 */
class PortionController extends Controller
{
    /** @var PortionRepository */
    private $portionRepository;

    /** @var PortionService */
    private $portionService;

    /** @var MealRepository */
    private $mealRepository;

    /** @var DayService */
    private $dayService;

    /**
     * @param PortionService $portionService
     * @param PortionRepository $portionRepository
     * @param MealRepository $mealRepository
     * @param DayService $dayService
     */
    public function __construct(
        PortionService $portionService,
        PortionRepository $portionRepository,
        MealRepository $mealRepository,
        DayService $dayService
    )
    {
        $this->portionRepository = $portionRepository;
        $this->portionService = $portionService;
        $this->mealRepository = $mealRepository;
        $this->dayService = $dayService;
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
     * @param Day $day
     * @param Portion $portion
     * @return PortionResource
     * @throws AuthorizationException
     */
    public function show(Day $day, Portion $portion)
    {
        $this->authorize('update', $portion);
        $this->authorize('update', $day);

        $foundedPortion = $this->portionRepository->findById($portion->id);

        return PortionResource::make($foundedPortion);
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

        $portionDTO = new PortionDTO($request->all());
        $portionDTO->setId(\Ulid::generate());

        $meal = $this->mealRepository->findById($portionDTO->getMealId());
        $this->authorize('view', $meal);
        $mealDTO = MealDTO::createFromModel($meal);

        $this->portionService->create($portionDTO, $mealDTO, Auth::user()->getAuthIdentifier(), $day->id);

        $createdPortion = $this->portionRepository->findById($portionDTO->getId());
        $createdPortion->wasRecentlyCreated = true;

        $this->dayService->refresh($day);

        return PortionResource::make($createdPortion);
    }

    /**
     * @param PortionRequest $request
     * @param Day $day
     * @param Portion $portion
     * @return PortionResource
     * @throws AuthorizationException
     * @throws DTOException
     */
    public function update(PortionRequest $request, Day $day, Portion $portion): PortionResource
    {
        $this->authorize('update', $portion);
        $this->authorize('update', $day);

        $portionDTO = new PortionDTO($request->all());

        if ($request->has('meal_id')) {
            $meal = $this->mealRepository->findById($portionDTO->getMealId());
            $this->authorize('view', $meal);
            $mealDTO = MealDTO::createFromModel($meal);
        } else {
            $mealDTO = null;
        }

        $this->portionService->update($portion, $portionDTO, $mealDTO);
        $updatedPortion = $this->portionRepository->findById($portion->id);

        $this->dayService->refresh($day);

        return PortionResource::make($updatedPortion);
    }

    /**
     * @param Day $day
     * @param Portion $portion
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Day $day, Portion $portion): void
    {
        $this->authorize('update', $day);
        $this->authorize('delete', $portion);

        $this->portionService->delete($portion);
    }
}