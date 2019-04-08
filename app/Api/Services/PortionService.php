<?php

namespace App\Api\Services;

use App\Api\Models\Portion;
use App\Api\Repositories\PortionRepository;
use Carbon\Carbon;

class PortionService
{
    /** @var PortionRepository */
    private $portionRepository;

    /**
     * PortionService constructor.
     * @param PortionRepository $portionRepository
     */
    public function __construct(PortionRepository $portionRepository)
    {
        $this->portionRepository = $portionRepository;
    }

    /**
     * @param Portion $portion
     */
    public function markEaten(Portion $portion): void
    {
        $this->portionRepository->update($portion, [
            'eaten' => true,
            'time_eaten' => Carbon::now()->format('H:i:s')
        ]);
    }

    /**
     * @param Portion $portion
     */
    public function unmarkEaten(Portion $portion): void
    {
        $this->portionRepository->update($portion, [
            'eaten' => false,
            'time_eaten' => null
        ]);
    }
}