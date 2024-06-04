<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Tests\Admin;

use Baijunyao\LaravelRestful\Tests\TestCase;
use Workbench\App\Models\Tag;

class TagControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $tags = $this->get('/admin/tags?include=categoriesCount')
            ->assertStatus(200)
            ->json('data');

        static::assertEquals([1, 1], array_column($tags, 'categories_count'));
    }

    public function testShowDeletedTag(): void
    {
        Tag::destroy(self::TAG_ID);

        $tag = $this->get('/admin/tags/' . self::TAG_ID)
            ->assertStatus(200)
            ->json('data');

        static::assertEquals(self::TAG_NAME, $tag['name']);
    }

    public function testUpdateDeletedTag(): void
    {
        Tag::destroy(self::TAG_ID);

        $name = self::TAG_NAME . ' updated';
        $tag  = $this->put('/admin/tags/' . self::TAG_ID, ['name' => $name])
            ->assertStatus(200)
            ->json('data');

        static::assertEquals($name, $tag['name']);
    }
}
