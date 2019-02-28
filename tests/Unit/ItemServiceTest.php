<?php

namespace Tests\Unit;

use App\Api\Services\ItemService;
use App\Api\Models\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see ItemService
 */
class ItemServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var ItemService */
    protected $itemService;

    /** @var Item */
    protected $item;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->itemService = $this->app->make(ItemService::class);
        $this->item = new Item();
    }

    /**
     * @see ItemService::create()
     * @return void
     */
    public function testCreate(): void
    {
        /** @var Item $item */
        $item = factory(Item::class)->make();
        $attributes = $item->attributesToArray();
        $this->itemService->create($attributes);

        $this->assertDatabaseHas($this->item->getTable(), $attributes);
    }

    /**
     * @see ItemService::update()
     */
    public function testUpdate(): void
    {
        $item = factory(Item::class)->create();
        $attributes = $item->attributesToArray();
        $attributes['title'] = 'not chicken breast';

        $this->itemService->update($item, $attributes);

        $this->assertDatabaseHas($this->item->getTable(), [
            'id' => $item->id,
            'title' => $attributes['title']
        ]);
    }

    /**
     * @see ItemService::delete()
     * @throws \Exception
     */
    public function testDelete(): void
    {
        $item = factory(Item::class)->create();
        $this->itemService->delete($item);
        $this->assertDatabaseMissing($this->item->getTable(), ['id' => $item->id]);
    }
}
