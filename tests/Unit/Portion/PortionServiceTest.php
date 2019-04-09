<?php

namespace Tests\Unit\Portion;

use App\Api\Models\Portion;
use App\Api\Services\PortionService;
use Carbon\Carbon;
use Tests\TestCase;

/**
 * @covers \App\Api\Services\PortionService
 */
class PortionServiceTest extends TestCase
{
    /** @var PortionService */
    private $service;

    /** @var Portion */
    private $portion;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->portion = new Portion();
        $this->service = app()->make(PortionService::class);
    }

    /**
     * @covers \App\Api\Services\PortionService::markEaten()
     */
    public function testMarkEaten(): void
    {
        $hasEaten = factory(Portion::class)->create(['eaten' => true]);
        $notEaten = factory(Portion::class)->create(['eaten' => false]);

        $portion = factory(Portion::class)->create(['eaten' => false, 'time_eaten' => '10:00']);
        $this->service->markEaten($portion);

        $this->assertDatabaseHas($this->portion->getTable(), [
            'id' => $portion->id,
            'eaten' => true,
            'time_eaten' => Carbon::now()->format('H:i')
        ]);
        $this->assertDatabaseHas($this->portion->getTable(), ['id' => $hasEaten->id, 'eaten' => true]);
        $this->assertDatabaseHas($this->portion->getTable(), ['id' => $notEaten->id, 'eaten' => false]);
    }

    /**
     * @covers \App\Api\Services\PortionService::unmarkEaten()
     */
    public function testUnmarkEaten(): void
    {
        $hasEaten = factory(Portion::class)->create(['eaten' => true]);
        $notEaten = factory(Portion::class)->create(['eaten' => false]);

        $portion = factory(Portion::class)->create(['eaten' => true]);
        $this->service->unmarkEaten($portion);

        $this->assertDatabaseHas($this->portion->getTable(), [
            'id' => $portion->id,
            'eaten' => false,
            'time_eaten' => null
        ]);

        $this->assertDatabaseHas($this->portion->getTable(), ['id' => $hasEaten->id, 'eaten' => true]);
        $this->assertDatabaseHas($this->portion->getTable(), ['id' => $notEaten->id, 'eaten' => false]);
    }
}