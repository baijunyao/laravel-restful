<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Tests\Home;

use App\Models\Tag;
use App\Observers\TagDeleted;
use App\Observers\TagRestored;
use Baijunyao\LaravelRestful\Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class TagControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $tags = $this->get('/home/tags')
            ->assertStatus(200)
            ->json('data');

        static::assertCount(2, $tags);
        static::assertEquals(self::TAG_NAME, $tags[0]['name']);
    }

    public function testShowDeletedTag(): void
    {
        Tag::destroy(self::TAG_ID);

        $this->get('/home/tags/' . self::TAG_ID)->assertStatus(404);
    }

    public function testUpdateDeletedTag(): void
    {
        Tag::destroy(self::TAG_ID);

        $name = self::TAG_NAME . ' updated';
        $this->put('/home/tags/' . self::TAG_ID, ['name' => $name])->assertStatus(404);
    }

    public function testDestroyAndForceDelete(): void
    {
        Event::fake();

        DB::table('tags')->where('id', self::TAG_ID)->update(['deleted_at' => now()]);
        static::assertNotNull(DB::table('tags')->where('id', self::TAG_ID)->first());

        $this->delete('/home/tags/' . self::TAG_ID . '/forceDelete')->assertStatus(204);

        static::assertNull(DB::table('tags')->where('id', self::TAG_ID)->first());
        Event::assertDispatched(TagDeleted::class);
    }

    public function testDestroyAndRestore(): void
    {
        Event::fake();

        DB::table('tags')->where('id', self::TAG_ID)->update(['deleted_at' => now()]);
        static::assertNotNull(DB::table('tags')->where('id', self::TAG_ID)->first());

        $this->patch('/home/tags/' . self::TAG_ID . '/restore')->assertStatus(200);

        Event::assertDispatched(TagRestored::class);
    }
}
