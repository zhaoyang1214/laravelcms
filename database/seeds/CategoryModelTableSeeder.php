<?php
use Illuminate\Database\Seeder;

class CategoryModelTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_model')->truncate();
        DB::table('category_model')->insert([
            [
                'name' => '新闻',
                'category' => 'categorynews',
                'content' => 'content',
                'status' => 1,
                'befrom' => 'laravel',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => '页面',
                'category' => 'categorypage',
                'content' => '',
                'status' => 1,
                'befrom' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => '跳转',
                'category' => 'categoryjump',
                'content' => '',
                'status' => 1,
                'befrom' => '',
                'create_time' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
