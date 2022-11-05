<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Tests\Home;

use App\Observers\CategoryCreated;
use App\Observers\CategoryDeleted;
use App\Observers\CategoryUpdated;
use Baijunyao\LaravelRestful\Tests\TestCase;
use Illuminate\Support\Facades\Event;

class CategoryControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $categories = $this->get('/home/categories')
            ->assertStatus(200)
            ->json('data');

        static::assertCount(2, $categories);
        static::assertEquals(self::CATEGORY_NAME, $categories[0]['name']);
    }

    public function testIndexFilters(): void
    {
        $query = [
            'filter[name]'       => self::CATEGORY_NAME,
            'fields[categories]' => 'id,tag_id,name',
            'include'            => 'tag',
        ];

        $categories = $this->get('/home/categories?' . http_build_query($query))
            ->assertStatus(200)
            ->json('data');

        static::assertCount(1, $categories);

        $category = $categories[0];

        static::assertEquals(self::CATEGORY_NAME, $category['name']);
        static::assertArrayNotHasKey('description', $category);
        static::assertArrayHasKey('tag', $category);
        static::assertEquals(self::TAG_NAME, $category['tag']['name']);
    }

    public function testIndexSort(): void
    {
        $categories = $this->get('/home/categories?sort=-id')
            ->assertStatus(200)
            ->json('data');

        static::assertCount(2, $categories);
        static::assertEquals(2, $categories[0]['id']);
    }

    public function testShow(): void
    {
        $category = $this->get('/home/categories/' . self::CATEGORY_ID . '?include=tag')
            ->assertStatus(200)
            ->json('data');

        static::assertEquals(self::CATEGORY_NAME, $category['name']);
        static::assertArrayHasKey('tag', $category);
        static::assertEquals(self::TAG_NAME, $category['tag']['name']);
    }

    public function testStore(): void
    {
        Event::fake();

        $name     = 'new category';
        $category = $this->post(
            '/home/categories',
            [
                'name'        => $name,
                'tag_id'      => null,
                'description' => 'new category description',
            ]
        )
            ->assertStatus(201)
            ->json('data');

        static::assertEquals($name, $category['name']);
        Event::assertDispatched(CategoryCreated::class);
    }

    public function testStoreError(): void
    {
        $response = $this->post(
            '/home/categories',
            [
                'description' => 'new category description',
            ],
            [
                'Accept' => 'application/json',
            ]
        )->assertStatus(422);

        static::assertEquals(
            '{"message":"The name field is required.","errors":{"name":["The name field is required."]}}',
            $response->getContent()
        );
    }

    public function testUpdate(): void
    {
        Event::fake();

        $name     = self::CATEGORY_NAME . ' updated';
        $category = $this->put('/home/categories/' . self::CATEGORY_ID, ['name' => $name])
            ->assertStatus(200)
            ->json('data');

        static::assertEquals($name, $category['name']);
        Event::assertDispatched(CategoryUpdated::class);
    }

    public function testDestroy(): void
    {
        Event::fake();

        $this->delete('/home/categories/' . self::CATEGORY_ID)->assertStatus(204);

        Event::assertDispatched(CategoryDeleted::class);
    }

    public function testDestroyWhenIdNotFound(): void
    {
        $this->delete('/home/categories/' . self::ID_NOT_FOUND)->assertStatus(404);
    }

    public function testForceDeleteError(): void
    {
        $response = $this->delete('/home/categories/' . self::CATEGORY_ID . '/forceDelete')->assertStatus(500);
        static::assertEquals(
            'You should add the Illuminate\Database\Eloquent\SoftDeletes trait to the App\Models\Category model.',
            $response->exception->getMessage()
        );
    }

    public function testRestoreError(): void
    {
        $response = $this->patch('/home/categories/' . self::CATEGORY_ID . '/restore')->assertStatus(500);
        static::assertEquals(
            'You should add the Illuminate\Database\Eloquent\SoftDeletes trait to the App\Models\Category model.',
            $response->exception->getMessage()
        );
    }
}
