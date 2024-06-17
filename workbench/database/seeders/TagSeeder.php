<?php

declare(strict_types=1);

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public const int TAG_ID           = 1;
    public const string TAG_NAME      = 'laravel restful tag';

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
    }
}
