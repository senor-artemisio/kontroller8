<?php

namespace Tests\Unit;

use App\Api\Repositories\ItemRepository;
use App\Api\DTO\ItemSnapshot;
use App\Api\Models\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see ItemRepository
 */
class ItemRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var ItemRepository */
    protected $itemRepository;

    /** @var Item */
    protected $item;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->itemRepository = $this->app->make(ItemRepository::class);
        $this->item = new Item();
    }

    /**
     * @see ItemRepository::create()
     * @return void
     */
    public function testCreate(): void
    {
        /** @var Item $item */
        $item = factory(Item::class)->make();
        $attributes = $item->attributesToArray();

        $this->itemRepository->create($attributes);

        $this->assertDatabaseHas($this->item->getTable(), $attributes);
    }

    /**
     * @see ItemRepository::update()
     */
    public function testUpdate(): void
    {
        /** @var Item $item */
        $item = factory(Item::class)->create();
        $attributes = $item->attributesToArray();
        $attributes['title'] = 'not chicken breast';

        $this->itemRepository->update($item, $attributes);

        $this->assertDatabaseHas($this->item->getTable(), [
            'id' => $item->id,
            'title' => $attributes['title']
        ]);
    }

    /**
     * @see ItemRepository::delete()
     * @throws \Exception
     */
    public function testDelete(): void
    {
        $item = factory(Item::class)->create();
        $this->itemRepository->delete($item);
        $this->assertDatabaseMissing($this->item->getTable(), ['id' => $item->id]);
    }
}
