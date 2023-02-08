<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('post')->insert(
            [
                'id' => 1,
                'name' => 'Bài viết 1',
                'image' => 'anh1.jpg',
                'description' => 'Bài viết 1',
            ],
            [
                'id' => 2,
                'name' => 'Bài viết 2',
                'image' => 'anh2.jpg',
                'description' => 'Bài viết 2',
            ],
            [
                'id' => 3,
                'name' => 'Bài viết 3',
                'image' => 'anh3.jpg',
                'description' => 'Bài viết 3',
            ],
            [
                'id' => 4,
                'name' => 'Bài viết 4',
                'image' => 'anh4.jpg',
                'description' => 'Bài viết 4',
            ]
        );
    }
}
