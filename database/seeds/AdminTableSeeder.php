<?php
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->truncate();
        DB::table('admin')->insert([
            [
                'id' => 1,
                'username' => 'admin',
                'password' => md5(md5('123456') . env('DB_PASSWORD_SALT')),
                'nickname' => '超级管理员',
                'regtime' => date('Y-m-d H:i:s'),
                'admin_group_id' => 1,
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'username' => 'laravel',
                'password' => md5(md5('123456') . env('DB_PASSWORD_SALT')),
                'nickname' => '管理员',
                'regtime' => date('Y-m-d H:i:s'),
                'admin_group_id' => 2,
                'create_time' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
