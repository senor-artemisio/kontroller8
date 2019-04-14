<?php

namespace Tests\Unit\Portion;

use App\Api\DTO\DTOException;
use App\Api\DTO\PortionDTO;
use App\Api\Models\Day;
use App\Api\Models\Portion;
use App\Api\Models\User;
use App\Api\Services\PortionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Api\Services\PortionService
 */
class PortionServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var PortionService */
    private $service;

    /** @var Portion */
    private $portion;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->portion = new Portion();
        $this->service = app()->make(PortionService::class);
    }

    /**
     * @return void
     * @throws DTOException
     * @see PortionService::create()
     */
    public function testCreate(): void
    {
        $day = factory(Day::class)->create();
        $portion = factory(Portion::class)->make();
        $user = factory(User::class)->create();
        $attributes = $portion->attributesToArray();
        unset(
            $attributes['created_at'],
            $attributes['updated_at'],
            $attributes['user_id'],
            $attributes['day_id']
        );

        $dto = new PortionDTO($attributes);
        $this->service->create($dto, $user->id, $day->id);

        $attributes['user_id'] = $user->id;
        $attributes['day_id'] = $day->id;
        $this->assertDatabaseHas($this->portion->getTable(), $attributes);
    }

    /**
     * @throws DTOException
     * @covers  \App\Api\Services\PortionService::update()
     */
    public function testUpdate(): void
    {
        $portion = factory(Portion::class)->create();
        $attributes = ['fat' => 10];
        $dto = new PortionDTO($attributes);

        $this->service->update($portion, $dto);

        $this->assertDatabaseHas($this->portion->getTable(), [
            'id' => $portion->id,
            'fat' => $attributes['fat']
        ]);
    }

    /**
     * @throws \Exception
     * @covers  \App\Api\Services\PortionService::delete()
     */
    public function testDelete(): void
    {
        $portion = factory(Portion::class)->create();
        $this->service->delete($portion);
        $this->assertDatabaseMissing($this->portion->getTable(), ['id' => $portion->id]);
    }
}