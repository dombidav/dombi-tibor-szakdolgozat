<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
