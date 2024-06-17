<?php

declare(strict_types=1);

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public const int CATEGORY_ID      = 1;
    public const string CATEGORY_NAME = 'laravel restful category';

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'id'          => self::CATEGORY_ID,
                'tag_id'      => TagSeeder::TAG_ID,
                'name'        => self::CATEGORY_NAME,
                'description' => 'laravel restful category description',
            ],
            [
                'id'          => 2,
                'tag_id'      => 2,
                'name'        => 'test',
                'description' => 'test',
            ],
        ]);
    }
}
