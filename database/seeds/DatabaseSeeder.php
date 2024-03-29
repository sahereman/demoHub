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
        $this->call(UsersTableSeeder::class);
        $this->call(AdminTablesSeeder::class);
        $this->call(DemosTableSeeder::class);
        $this->call(DemoDesignersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(DraftsTableSeeder::class);
    }
}
