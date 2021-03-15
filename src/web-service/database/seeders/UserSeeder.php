<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory([
            'name' => 'Administrator',
            'email' => 'admin@acs.test',
        ])->create();

        User::factory([
            'name' => 'Test Supervisor',
            'email' => 'supervisor@acs.test',
        ])->create();

        User::factory([
            'name' => 'Test Security Guard',
            'email' => 'guard@acs.test',
        ])->create();

        User::factory(50)->create();
    }
}
