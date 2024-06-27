<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Tests\Admin;

use Baijunyao\LaravelRestful\Tests\TestCase;
use Workbench\App\Models\Category;

class CategoryControllerTest extends TestCase
{
    public function testShow(): void
    {
        Category::destroy(self::CATEGORY_ID);

        $response = $this->getJson('/api/admin/categories/' . self::CATEGORY_ID);

        static::assertEquals(
            'You should add the Illuminate\Database\Eloquent\SoftDeletes trait to the Workbench\App\Models\Category model.',
            $response->exception->getMessage()
        );
    }

    public function testUpdate(): void
    {
        Category::destroy(self::CATEGORY_ID);

        $response = $this->putJson('/api/admin/categories/' . self::CATEGORY_ID, ['name' => self::CATEGORY_NAME . ' updated'])->assertStatus(500);

        static::assertEquals(
            'You should add the Illuminate\Database\Eloquent\SoftDeletes trait to the Workbench\App\Models\Category model.',
            $response->exception->getMessage()
        );
    }
}
