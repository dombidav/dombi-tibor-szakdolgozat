<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(BouncerSeeder::class);
        $this->call(WorkerSeeder::class);
        $this->call(LockSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(WorkerGroupingSeeder::class);
        $this->call(AccessRuleSeeder::class);
    }
}
