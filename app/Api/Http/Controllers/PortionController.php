<?php

namespace App\Api\Http\Controllers;

use App\Api\Http\Resources\PortionResource;
use App\Api\Models\Portion;
use App\Api\Repositories\DayRepository;
use App\Api\Repositories\PortionRepository;
use App\Api\Services\DayService;
use App\Api\Services\PortionService;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * @param Portion $portion
     * @return PortionResource
     * @throws AuthorizationException
     */
    public function markEaten(Portion $portion): PortionResource
    {
        $this->authorize('markEaten', $portion);
        $this->portionService->markEaten($portion);

        $day = $this->dayRepository->findById($portion->day_id);
        if ($day === null) {
            throw new ModelNotFoundException('Day not found.');
        }
        $this->dayService->refresh($day);

        $updatedPortion = $this->portionRepository->findById($portion->id);

        return PortionResource::make($updatedPortion);
    }

    /**
     * @param Portion $portion
     * @return PortionResource
     * @throws AuthorizationException
     */
    public function unmarkEaten(Portion $portion): PortionResource
    {
        $this->authorize('unmarkEaten', $portion);
        $this->portionService->unmarkEaten($portion);

        $day = $this->dayRepository->findById($portion->day_id);
        if ($day === null) {
            throw new ModelNotFoundException('Day not found.');
        }
        $this->dayService->refresh($day);

        $updatedPortion = $this->portionRepository->findById($portion->id);

        return PortionResource::make($updatedPortion);
    }
}