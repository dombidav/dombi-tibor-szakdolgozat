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
        $this->call(TeamSeeder::class);
        $this->call(WorkerGroupingSeeder::class);
        $this->call(LockSeeder::class);
        $this->call(LockGroupSeeder::class);
        $this->call(LockGroupingSeeder::class);
        $this->call(AccessRuleSeeder::class);
        $this->call(RulingSeeder::class);
        $this->call(LogSeeder::class);
    }
}
