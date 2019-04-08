<?php

namespace App\Api\Http\Controllers;

use App\Api\Http\Requests\PortionRequest;
use App\Api\Repositories\PortionRepository;
use App\Api\Services\PortionService;
use App\Http\Controllers\Controller;

class PortionController extends Controller
{
    private $portionRepository;

    /** @var PortionService */
    private $portionService;

    public function __construct(PortionService $portionService, PortionRepository $portionRepository)
    {
        $this->portionRepository = $portionRepository;
        $this->portionService = $portionService;
    }

    public function update(PortionRequest $portionRequest)
    {

    }
}