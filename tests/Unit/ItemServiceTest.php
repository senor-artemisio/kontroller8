<?php

namespace Tests\Unit;

use App\Api\DTO\ItemDTO;
use App\Api\Models\User;
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
     * @throws \App\Api\DTO\DTOException
     */
    public function testCreate(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        $this->actingAs($user);

        /** @var Item $item */
        $item = factory(Item::class)->make();
        $attributes = $item->attributesToArray();
        unset($attributes['created_at'], $attributes['updated_at'], $attributes['user_id']);

        $dto = new ItemDTO($attributes);
        $this->itemService->create($dto);

        $attributes['user_id'] = $user->id;
        $this->assertDatabaseHas($this->item->getTable(), $attributes);
    }

    /**
     * @see ItemService::update()
     * @throws \App\Api\DTO\DTOException
     */
    public function testUpdate(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $item = factory(Item::class)->create();
        $attributes = ['title' => 'chicken breast'];
        $dto = new ItemDTO($attributes);

        $this->itemService->update($item, $dto);

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
