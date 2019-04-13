<?php

namespace Tests\Feature;

use App\Api\Models\Day;
use App\Api\Models\Meal;
use App\Api\Models\Portion;
use App\Api\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * @covers \App\Api\Http\Controllers\DayController
 */
class DayApiTest extends TestCase
{
    use RefreshDatabase;

    /** @var User */
    private $user;

    /** @var Day */
    protected $dayModel;

    /** @var */
    private $weekDates;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->dayModel = new Day();
        $this->user = factory(User::class)->create();
    }


}