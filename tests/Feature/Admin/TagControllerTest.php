<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Tests\Admin;

use App\Http\Controllers\Admin\TagController;
use App\Models\Tag;
use Baijunyao\LaravelRestful\Tests\TestCase;

class TagControllerTest extends TestCase
{
    public function testShowDeletedTag(): void
    {
        Tag::destroy(self::TAG_ID);

        $tag = $this->get('/tags/' . self::TAG_ID)
            ->assertStatus(200)
            ->json('data');

        static::assertEquals(self::TAG_NAME, $tag['name']);
    }

    public function testUpdateDeletedTag(): void
    {
        Tag::destroy(self::TAG_ID);

        $name = self::TAG_NAME . ' updated';
        $tag  = $this->put('/tags/' . self::TAG_ID, ['name' => $name])
            ->assertStatus(200)
            ->json('data');

        static::assertEquals($name, $tag['name']);
    }

    protected function defineRoutes($router)
    {
        $router->resource('tags', TagController::class)->only('show', 'update');
    }
}
