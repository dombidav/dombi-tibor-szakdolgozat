<?php

namespace Database\Seeders;

use App\Models\Lock;
use Illuminate\Database\Seeder;

class LockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Lock::factory(50)->create();
    }
}
