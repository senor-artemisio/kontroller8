<?php

namespace Tests\Unit\Day;

use App\Api\DTO\DayDTO;
use App\Api\DTO\DTOException;
use App\Api\Models\Day;
use App\Api\Models\User;
use App\Api\Services\DayService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * @covers \App\Api\Services\DayService
 */
class DayServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var DayService */
    private $service;

    /** @var Day */
    private $day;

    /** @var User */
    private $user;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(DayService::class);
        $this->day = new Day();
        $this->user = factory(User::class)->create();
    }

    /**
     * @covers \App\Api\Services\DayService::create()
     * @throws DTOException
     */
    public function testCreate(): void
    {
        $dto = new DayDTO([
            'id' => \Ulid::generate(),
            'date' => Carbon::now()->format('Y-m-d')
        ]);

        $this->service->create($dto, $this->user->id);

        $this->assertDatabaseHas('days', [
            'id' => $dto->getId(),
            'date' => $dto->getDate(),
            'protein' => 0,
            'fat' => 0,
            'fiber' => 0,
            'weight' => 0,
            'protein_eaten' => 0,
            'fat_eaten' => 0,
            'fiber_eaten' => 0,
            'weight_eaten' => 0
        ]);
    }

    /**
     * @throws \Exception
     * @covers  \App\Api\Services\DayService::delete()
     */
    public function testDelete(): void
    {
        $day = factory(Day::class)->create();
        $this->service->delete($day);
        $this->assertDatabaseMissing($this->day->getTable(), ['id' => $day->id]);
    }
}