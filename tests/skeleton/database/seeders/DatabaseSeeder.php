<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public const TAG_ID        = 1;
    public const TAG_NAME      = 'laravel restful tag';
    public const CATEGORY_ID   = 1;
    public const CATEGORY_NAME = 'laravel restful category';

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            [
                'id'   => self::TAG_ID,
                'name' => self::TAG_NAME,
            ],
            [
                'id'   => 2,
                'name' => 'test',
            ],
        ]);

        DB::table('categories')->insert([
            [
                'id'          => self::CATEGORY_ID,
                'tag_id'      => 1,
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
