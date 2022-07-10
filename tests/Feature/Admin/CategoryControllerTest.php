<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Tests\Admin;

use App\Http\Controllers\Admin\CategoryController;
use App\Models\Category;
use Baijunyao\LaravelRestful\Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function testShow(): void
    {
        Category::destroy(self::CATEGORY_ID);

        $response = $this->get('/categories/' . self::CATEGORY_ID);

        static::assertEquals(
            'You should add the Illuminate\Database\Eloquent\SoftDeletes trait to the App\Models\Category model.',
            $response->exception->getMessage()
        );
    }

    public function testUpdate(): void
    {
        Category::destroy(self::CATEGORY_ID);

        $response = $this->put('/categories/' . self::CATEGORY_ID, ['name' => self::CATEGORY_NAME . ' updated'])->assertStatus(500);

        static::assertEquals(
            'You should add the Illuminate\Database\Eloquent\SoftDeletes trait to the App\Models\Category model.',
            $response->exception->getMessage()
        );
    }

    protected function defineRoutes($router)
    {
        $router->resource('categories', CategoryController::class)->only('show', 'update');
    }
}
