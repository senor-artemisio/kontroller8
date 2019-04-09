<?php

namespace Tests\Unit\Portion;

use App\Api\Models\Portion;
use App\Api\Repositories\PortionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Api\Repositories\PortionRepository
 */
class PortionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var PortionRepository */
    private $repository;

    /** @var Portion */
    private $portion;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->portion = new Portion();
        $this->repository = app()->make(PortionRepository::class);
    }

    /**
     * @covers \App\Api\Repositories\PortionRepository::findById()
     */
    public function testFindById(): void
    {
        $portion = factory(Portion::class)->create();
        $portionFounded = $this->repository->findById($portion->id);
        $this->assertEquals($portion->id, $portionFounded->id);
        $portionNotFounded = $this->repository->findById(\Ulid::generate());
        $this->assertNull($portionNotFounded);
    }

    /**
     * @covers \App\Api\Repositories\PortionRepository::update()
     */
    public function testUpdate(): void
    {
        /** @var Portion $anotherPortion */
        $anotherPortion = factory(Portion::class)->create();
        $portion = factory(Portion::class)->create();
        $attributes = [
            'protein' => 10,
            'fat' => 10,
            'carbohydrates' => 10,
            'time_eaten' => '10:00'
        ];

        $this->repository->update($portion, $attributes);
        $attributes['id'] = $portion->id;

        $this->assertDatabaseHas($this->portion->getTable(), $attributes);
        $this->assertDatabaseHas($this->portion->getTable(), $anotherPortion->attributesToArray());
    }
}