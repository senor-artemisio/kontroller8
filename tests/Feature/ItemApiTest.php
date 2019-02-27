<?php

namespace Tests\Feature;

use App\Api\Http\Controllers\ItemController;
use App\Api\Models\User;
use App\Api\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * @see ItemController
 */
class ItemApiTest extends TestCase
{
    use RefreshDatabase;

    /** @var Item */
    protected $item;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->item = new Item();
    }

    /**
     * @see ItemController::index()
     */
    public function testIndexUnauthorized(): void
    {
        $this->getJson('/api/items')->assertStatus(401);
    }

    /**
     * @see ItemController::index()
     */
    public function testIndexOwner(): void
    {
        $user = factory(User::class)->create();

        /** @var Collection $items */
        $items = factory(Item::class, 5)->create(['user_id' => $user->id]);
        factory(Item::class, 10)->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/items');
        $response->assertStatus(200);

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertCount(5, $data);

        $dataIDs = array_column($data, 'id');
        $items->each(function (Item $item) use ($dataIDs) {
            $this->assertContains($item->id, $dataIDs);
        });

        $meta = $response->decodeResponseJson('meta');
        $this->assertNotNull($meta);
        $this->assertArrayHasKey('total', $meta);
        $this->assertEquals(5, $meta['total']);
    }

    /**
     * @see ItemController::show()
     */
    public function testShowUnauthorized(): void
    {
        $item = factory(Item::class)->create();
        $this->getJson("/api/items/{$item->id}")->assertStatus(401);
    }

    /**
     * @see ItemController::show()
     */
    public function testShowAuthorized(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        /** @var Item $item */
        $item = factory(Item::class)->create(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->getJson("/api/items/$item->id");
        $response->assertStatus(200);
        $data = $response->decodeResponseJson('data');

        $this->assertNotNull($data);
        $this->assertEquals($item->toArray(), $this->arraySnakeCase($data));
    }


    /**
     * Проверка пагинации в списке продуктов.
     *
     * @return void
     */
    public function testPagination(): void
    {
        $user = factory(User::class)->create();

        /** @var Collection $items */
        $items = factory(Item::class, 35)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->getJson('/api/items');
        $response->assertStatus(200);

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertCount(20, $data);

        $itemsIDS = $items->pluck('id')->toArray();

        foreach ($data as $item) {
            $this->assertContains($item['id'], $itemsIDS);
        }
    }

    /**
     * Проверка создания продукта.
     *
     * @return void
     */
    public function testCreate(): void
    {
        $user = factory(User::class)->create();
        $itemData = [
            'title' => 'куриная грудка',
            'protein' => 23.5,
            'fat' => 1.2,
            'carbohydrates' => 4.3,
            'fiber' => 0
        ];
        $response = $this->actingAs($user, 'api')->postJson('/api/items', $itemData);
        $response->assertStatus(201);

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);

        $itemData['id'] = $data['id'];
        $itemData['userId'] = $user->id;
        $itemData['createdAt'] = $data['createdAt'];
        $itemData['updatedAt'] = $data['updatedAt'];

        $this->assertEquals($data, $itemData);
        $this->assertDatabaseHas($this->item->getTable(), $this->arraySnakeCase($data));
    }

    /**
     * Проверка обновления продукта.
     */
    public function testUpdate(): void
    {
        $user = factory(User::class)->create();
        $item = factory(Item::class)->create(['user_id' => $user->id]);
        $itemData = ['title' => 'не куриная грудка'];

        $response = $this->actingAs($user, 'api')->patchJson("/api/items/$item->id", $itemData);
        $response->assertStatus(200);

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);

        $this->assertEquals($data['title'], $itemData['title']);
        $this->assertEquals($data['id'], $item->id);
        $this->assertDatabaseHas($this->item->getTable(), [
            'id' => $item->id,
            'title' => $itemData['title']
        ]);
    }

    /**
     * Проверка удаления продукта.
     */
    public function testDelete(): void
    {
        $user = factory(User::class)->create();
        $item = factory(Item::class)->create(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->deleteJson("/api/items/$item->id");
        $response->assertStatus(204);
        $this->assertDatabaseMissing($this->item->getTable(), ['id' => $item->id]);
    }
}
