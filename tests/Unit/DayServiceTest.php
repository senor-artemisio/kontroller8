<?php

namespace Tests\Unit;

use App\Api\DTO\DayDTO;
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
    protected $dayService;

    /** @var Day */
    protected $day;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->dayService = $this->app->make(DayService::class);
        $this->day = new Day();
    }

    /**
     * @covers \App\Api\Services\DayService::create()
     * @throws \App\Api\DTO\DTOException
     */
    public function testCreate(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $dto = new DayDTO([
            'id' => \Ulid::generate(),
            'date' => Carbon::now()->format('Y-m-d')
        ]);

        $this->dayService->create($dto, $user->id);

        $this->assertDatabaseHas('days', [
            'id' => $dto->id,
            'date' => $dto->date,
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
}