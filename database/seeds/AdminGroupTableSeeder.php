<?php
use Illuminate\Database\Seeder;

class AdminGroupTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_group')->truncate();
        DB::table('admin_group')->insert([
            [
                'id' => 1,
                'pid' => 0,
                'name' => '超级管理组',
                'grade' => 1,
                'keep' => 7,
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'pid' => 1,
                'name' => '管理员组',
                'grade' => 10,
                'keep' => 3,
                'create_time' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
