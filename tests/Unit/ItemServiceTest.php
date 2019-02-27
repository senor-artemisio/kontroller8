<?php

namespace Tests\Unit;

use App\Api\Services\ItemService;
use App\Api\Snapshots\ItemSnapshot;
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
        $itemSnapshot = ItemSnapshot::createFromItem(factory(Item::class)->make());

        $this->itemService->create($itemSnapshot);

        $this->assertDatabaseHas($this->item->getTable(), $itemSnapshot->getAttributes());
    }

    /**
     * @see ItemService::update()
     */
    public function testUpdate(): void
    {
        $item = factory(Item::class)->create();
        $itemSnapshot = new ItemSnapshot();
        $itemSnapshot->setTitle('не куриная грудка');

        $this->itemService->update($item, $itemSnapshot);

        $this->assertDatabaseHas($this->item->getTable(), [
            'id' => $item->id,
            'title' => $itemSnapshot->getTitle()
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
