<?php

namespace Tests\Unit\Item;

use App\Api\DTO\DTOException;
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
     * @return void
     * @throws DTOException
     * @see ItemService::create()
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
        $this->itemService->create($dto, $user->id);

        $attributes['user_id'] = $user->id;
        $this->assertDatabaseHas($this->item->getTable(), $attributes);
    }

    /**
     * @throws DTOException
     * @see ItemService::update()
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
     * @throws \Exception
     * @see ItemService::delete()
     */
    public function testDelete(): void
    {
        $item = factory(Item::class)->create();
        $this->itemService->delete($item);
        $this->assertDatabaseMissing($this->item->getTable(), ['id' => $item->id]);
    }
}
