<?php

namespace Database\Seeders;

use App\Models\User;
use App\Utils\Bouncer;
use Illuminate\Database\Seeder;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @noinspection NullPointerExceptionInspection | Reasoning: User table is already seeded
     */
    public function run(): void
    {
        User::where('email', 'like', 'admin@acs.test')->first()->assign('admin');
        User::where('email', 'like', 'supervisor@acs.test')->first()->assign('supervisor');
        User::where('email', 'like', 'guard@acs.test')->first()->assign('guard');

        Bouncer::allow('admin')->everything();
        Bouncer::allow('supervisor')->everything();
        Bouncer::forbid('supervisor')->toManage(User::class);
        Bouncer::forbid('guard')->everything();
    }
}
