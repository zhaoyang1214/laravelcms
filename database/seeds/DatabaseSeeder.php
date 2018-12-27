<?php
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminAuthTableSeeder::class,
            AdminGroupTableSeeder::class,
            AdminTableSeeder::class,
            CategoryModelTableSeeder::class
        ]);
    }
}
