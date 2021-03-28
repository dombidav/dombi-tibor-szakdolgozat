<?php

namespace Database\Seeders;

use App\Models\AccessRule;
use Illuminate\Database\Seeder;

class AccessRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        AccessRule::factory(50)->create();
    }
}
