<?php

namespace Tests\Unit;

use App\Api\Repositories\ItemRepository;
use App\Api\Snapshots\ItemSnapshot;
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
        $itemSnapshot = ItemSnapshot::createFromItem(factory(Item::class)->make());

        $this->itemRepository->create($itemSnapshot);

        $this->assertDatabaseHas($this->item->getTable(), $itemSnapshot->getAttributes());
    }

    /**
     * @see ItemRepository::update()
     */
    public function testUpdate(): void
    {
        $item = factory(Item::class)->create();
        $itemSnapshot = new ItemSnapshot();
        $itemSnapshot->setTitle('не куриная грудка');

        $this->itemRepository->update($item, $itemSnapshot);

        $this->assertDatabaseHas($this->item->getTable(), [
            'id' => $item->id,
            'title' => $itemSnapshot->getTitle()
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
