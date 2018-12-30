<?php
use Illuminate\Database\Seeder;

class AdminAuthTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_auth')->truncate();
        DB::table('admin_auth')->insert([
            [
                'id' => 1,
                'name' => '首页管理',
                'controller' => 'Index',
                'action' => 'home'
            ]
        ]);
    }
}
