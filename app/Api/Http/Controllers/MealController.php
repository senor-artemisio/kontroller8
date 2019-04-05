<?php

namespace App\Api\Http\Controllers;

use App\Api\DTO\DTOException;
use App\Api\DTO\MealDTO;
use App\Api\Http\Requests\MealRequest;
use App\Api\Http\Requests\MealsRequest;
use App\Api\Http\Resources\MealResource;
use App\Api\Repositories\MealRepository;
use App\Api\Services\MealService;
use App\Http\Controllers\Controller;
use App\Api\Models\Meal;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * REST API for meals.
 */
class MealController extends Controller
{
    /** @var MealService */
    private $mealService;

    /** @var MealRepository */
    private $mealRepository;

    /**
     * @param MealService $mealService
     * @param MealRepository $mealRepository
     */
    public function __construct(MealService $mealService, MealRepository $mealRepository)
    {
        $this->mealService = $mealService;
        $this->mealRepository = $mealRepository;
    }

    /**
     * @param MealsRequest $request
     * @return ResourceCollection
     * @throws AuthorizationException
     */
    public function index(MealsRequest $request): ResourceCollection
    {
        $this->authorize('list', Meal::class);
        $userId = Auth::user()->getAuthIdentifier();

        $meals = $this->mealRepository
            ->paginate($request->getPerPage())
            ->sort($request->getSortBy(), $request->getSortDirection())
            ->findByOwner($userId);

        return MealResource::collection($meals);
    }

    /**
     * @param Meal $meal
     * @return MealResource
     * @throws AuthorizationException
     */
    public function show(Meal $meal): MealResource
    {
        $this->authorize('view', $meal);

        return MealResource::make($meal);
    }

    /**
     * @param MealRequest $request
     * @return MealResource
     * @throws DTOException
     */
    public function store(MealRequest $request): MealResource
    {
        $dto = new MealDTO($request->all());
        $dto->id = \Ulid::generate();

        $this->mealService->create($dto, Auth::user()->getAuthIdentifier());
        $meal = $this->mealRepository->findById($dto->id);
        $meal->wasRecentlyCreated = true;

        return MealResource::make($meal);
    }


    /**
     * @param Meal $meal
     * @param MealRequest $request
     * @return MealResource
     * @throws AuthorizationException
     * @throws DTOException
     */
    public function update(Meal $meal, MealRequest $request): MealResource
    {
        $this->authorize('update', $meal);

        $dto = new MealDTO($request->all());

        $this->mealService->update($meal, $dto);

        $updatedMeal = $this->mealRepository->findById($meal->id);

        return MealResource::make($updatedMeal);
    }

    /**
     * @param Meal $meal
     * @return ResponseFactory|Response
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Meal $meal)
    {
        $this->authorize('delete', $meal);
        $this->mealService->delete($meal);

        return response()->json(null, 204);
    }
}