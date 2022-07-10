<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Tests\Home;

use App\Http\Controllers\Home\TagController;
use App\Models\Tag;
use App\Observers\TagDeleted;
use App\Observers\TagRestored;
use Baijunyao\LaravelRestful\Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class TagControllerTest extends TestCase
{
    public function testShowDeletedTag(): void
    {
        Tag::destroy(self::TAG_ID);

        $this->get('/tags/' . self::TAG_ID)->assertStatus(404);
    }

    public function testUpdateDeletedTag(): void
    {
        Tag::destroy(self::TAG_ID);

        $name = self::TAG_NAME . ' updated';
        $this->put('/tags/' . self::TAG_ID, ['name' => $name])->assertStatus(404);
    }

    public function testDestroyAndForceDelete(): void
    {
        Event::fake();

        DB::table('tags')->where('id', self::TAG_ID)->update(['deleted_at' => now()]);
        static::assertNotNull(DB::table('tags')->where('id', self::TAG_ID)->first());

        $this->delete('/tags/' . self::TAG_ID . '/forceDelete')->assertStatus(204);

        static::assertNull(DB::table('tags')->where('id', self::TAG_ID)->first());
        Event::assertDispatched(TagDeleted::class);
    }

    public function testDestroyAndRestore(): void
    {
        Event::fake();

        DB::table('tags')->where('id', self::TAG_ID)->update(['deleted_at' => now()]);
        static::assertNotNull(DB::table('tags')->where('id', self::TAG_ID)->first());

        $this->patch('/tags/' . self::TAG_ID . '/restore')->assertStatus(200);

        Event::assertDispatched(TagRestored::class);
    }

    protected function defineRoutes($router)
    {
        $router->resource('tags', TagController::class)->only('show', 'update');
        $router->patch('tags/{tag}/restore', TagController::class . '@restore')->name('tags.restore');
        $router->delete('tags/{tag}/forceDelete', TagController::class . '@forceDelete')->name('tags.forceDelete');
    }
}
