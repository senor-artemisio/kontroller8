<?php

namespace Tests\Feature;

use App\Api\Http\Controllers\ItemController;
use App\Api\Models\User;
use App\Api\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * Feature test for item API.
 *
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
     * Check view items list for unauthorized user.
     *
     * @see ItemController::index()
     */
    public function testIndexUnauthorized(): void
    {
        $this->getJson('/api/items')->assertStatus(401);
    }

    /**
     * Check view items list for authorized user.
     *
     * @see ItemController::index()
     */
    public function testIndexAuthorized(): void
    {
        $user = factory(User::class)->create();

        /** @var Collection $items */
        $items = factory(Item::class, 5)->create(['user_id' => $user->id]);
        factory(Item::class, 10)->create();

        $response = $this->actingAs($user, 'api')->getJson(
            '/api/items?page=1&perPage=10&sortBy=title&sortDirection=asc'
        );
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
     * Check view item for unauthorized user.
     *
     * @see ItemController::show()
     */
    public function testShowUnauthorized(): void
    {
        $item = factory(Item::class)->create();
        $this->getJson("/api/items/{$item->id}")->assertStatus(401);
    }

    /**
     * Check view item for authorized user.
     *
     * @see ItemController::show()
     */
    public function testShowAuthorized(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        /** @var Item $item */
        $item = factory(Item::class)->create();
        $response = $this->actingAs($user, 'api')->getJson("/api/items/$item->id");
        $response->assertStatus(403);
    }

    /**
     * Check view item for owner.
     *
     * @see ItemController::show()
     */
    public function testShowOwner(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        /** @var Item $item */
        $item = factory(Item::class)->create(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->getJson("/api/items/$item->id");
        $response->assertStatus(200);
        $data = $response->decodeResponseJson('data');

        unset($data['type']);

        $this->assertNotNull($data);
        $this->assertEquals($item->toArray(), $data);
    }


    /**
     * Check pagination for items.
     *
     * @see ItemController::index()
     */
    public function testPagination(): void
    {
        $user = factory(User::class)->create();

        /** @var Collection $items */
        $items = factory(Item::class, 35)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->getJson(
            '/api/items?page=1&perPage=20&sortBy=title&sortDirection=asc'
        );
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
     * Check create item for authorized user.
     *
     * @see ItemController::store()
     */
    public function testCreateAuthorized(): void
    {
        $user = factory(User::class)->create();
        $itemData = [
            'title' => 'chicken breast',
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
        $itemData['user_id'] = $user->id;
        $itemData['created_at'] = $data['created_at'];
        $itemData['updated_at'] = $data['updated_at'];

        unset($data['type']);

        $this->assertEquals($data, $itemData);
        $this->assertDatabaseHas($this->item->getTable(), $data);
    }

    /**
     * Check create item for unauthorized user.
     *
     * @see ItemController::store()
     */
    public function testCreateUnauthorized(): void
    {
        $itemData = [
            'title' => 'chicken breast',
            'protein' => 23.5,
            'fat' => 1.2,
            'carbohydrates' => 4.3,
            'fiber' => 0
        ];
        $response = $this->postJson('/api/items', $itemData);
        $response->assertStatus(401);
    }

    /**
     * Check update item for authorized user.
     *
     * @see ItemController::update()
     */
    public function testUpdateAuthorized(): void
    {
        $user = factory(User::class)->create();
        $item = factory(Item::class)->create();
        $itemData = ['title' => 'not chicken breast'];

        $response = $this->actingAs($user, 'api')->patchJson("/api/items/$item->id", $itemData);
        $response->assertStatus(403);
    }

    /**
     * Check update item for owner.
     *
     * @see ItemController::update()
     */
    public function testUpdateOwner(): void
    {
        $user = factory(User::class)->create();
        $item = factory(Item::class)->create(['user_id' => $user->id]);
        $itemData = ['title' => 'not chicken breast'];

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
     * Check update item for unauthorized user.
     *
     * @see ItemController::update()
     */
    public function testUpdateUnauthorized(): void
    {
        $user = factory(User::class)->create();
        $item = factory(Item::class)->create(['user_id' => $user->id]);
        $itemData = ['title' => 'not chicken breast'];

        $response = $this->patchJson("/api/items/$item->id", $itemData);
        $response->assertStatus(401);
    }

    /**
     * Check delete item for authorized user.
     *
     * @see ItemController::destroy()
     */
    public function testDeleteAuthorized(): void
    {
        $user = factory(User::class)->create();
        $item = factory(Item::class)->create();
        $response = $this->actingAs($user, 'api')->deleteJson("/api/items/$item->id");
        $response->assertStatus(403);
    }

    /**
     * Check delete item for owner.
     *
     * @see ItemController::destroy()
     */
    public function testDeleteOwner(): void
    {
        $user = factory(User::class)->create();
        $item = factory(Item::class)->create(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->deleteJson("/api/items/$item->id");
        $response->assertStatus(204);
        $this->assertDatabaseMissing($this->item->getTable(), ['id' => $item->id]);
    }

    /**
     * Check delete item for unauthorized user.
     *
     * @see ItemController::destroy()
     */
    public function testDeleteUnauthorized(): void
    {
        $user = factory(User::class)->create();
        $item = factory(Item::class)->create(['user_id' => $user->id]);
        $response = $this->deleteJson("/api/items/$item->id");
        $response->assertStatus(401);
        $this->assertDatabaseHas($this->item->getTable(), ['id' => $item->id]);
    }
}
