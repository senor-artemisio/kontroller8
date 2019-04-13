<?php

namespace Tests\Unit\Portion;

use App\Api\Models\Portion;
use App\Api\Repositories\PortionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @covers \App\Api\Repositories\PortionRepository::create()
     */
    public function testCreate(): void
    {
        $portion = factory(Portion::class)->make();
        $attributes = $portion->attributesToArray();

        $this->repository->create($attributes);

        $this->assertDatabaseHas($this->portion->getTable(), $attributes);
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
            'time' => '10:00'
        ];

        $this->repository->update($portion, $attributes);
        $attributes['id'] = $portion->id;

        $this->assertDatabaseHas($this->portion->getTable(), $attributes);
        $this->assertDatabaseHas($this->portion->getTable(), $anotherPortion->attributesToArray());
    }

    /**
     * @covers \App\Api\Repositories\PortionRepository::delete()
     * @throws \Exception
     */
    public function testDelete(): void
    {
        $portion = factory(Portion::class)->create();
        $this->repository->delete($portion);
        $this->assertDatabaseMissing($this->portion->getTable(), ['id' => $portion->id]);
    }

    /**
     * @covers \App\Api\Repositories\PortionRepository::findById()
     */
    public function testFindById(): void
    {
        $portion = factory(Portion::class)->create();
        $portionFounded = $this->repository->findById($portion->id);
        $this->assertEquals($portion->id, $portionFounded->id);
    }

    /**
     * @covers \App\Api\Repositories\PortionRepository::findById()
     */
    public function testFindByIdNotExists(): void
    {
        factory(Portion::class)->create();
        $this->expectException(ModelNotFoundException::class);
        $this->repository->findById(\Ulid::generate());
    }

    /**
     * @covers \App\Api\Repositories\PortionRepository::findByDay()
     */
    public function testFindByDay(): void
    {
        factory(Portion::class, 3)->create();
        $portion = factory(Portion::class)->create();

        $portions = $this->repository->findByDay($portion->day_id);
        $this->assertCount(1, $portions);
        $this->assertEquals($portion->id, $portions->first()->id);
    }
}