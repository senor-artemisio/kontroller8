<?php

namespace App\Api\Http\Controllers;

use App\Api\Http\Resources\PortionResource;
use App\Api\Models\Portion;
use App\Api\Repositories\PortionRepository;
use App\Api\Services\PortionService;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

class PortionController extends Controller
{
    /** @var PortionRepository */
    private $portionRepository;

    /** @var PortionService */
    private $portionService;

    /**
     * @param PortionService $portionService
     * @param PortionRepository $portionRepository
     */
    public function __construct(PortionService $portionService, PortionRepository $portionRepository)
    {
        $this->portionRepository = $portionRepository;
        $this->portionService = $portionService;
    }

    /**
     * @param Portion $portion
     * @return PortionResource
     * @throws AuthorizationException
     */
    public function markEaten(Portion $portion)
    {
        $this->authorize('update', $portion);
        $this->markEaten($portion);

        $updatedPortion = $this->portionRepository->findById($portion->id);

        return PortionResource::make($updatedPortion);
    }
}