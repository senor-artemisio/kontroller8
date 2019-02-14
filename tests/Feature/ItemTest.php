<?php

namespace Tests\Feature;

use App\Api\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * Проверка API для сущности «продукт»
 */
class ItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверка корректности отображения продуктов владельцу.
     *
     * @return void
     */
    public function testOwner(): void
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

        $this->assertEquals($data, $itemData);
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
    }
}
