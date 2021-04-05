<?php

namespace Database\Seeders;

use App\Models\LockGroup;
use Illuminate\Database\Seeder;

class LockGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        LockGroup::factory(50)->create();
    }
}
