<?php

namespace Database\Seeders;

use App\Models\AccessRule;
use App\Models\Team;
use App\Models\LockGroup;
use Illuminate\Database\Seeder;

class RulingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //First run: Teams to Rules
        $teams = Team::inRandomOrder()->get();
        /** @var Team $team */
        foreach ($teams as $team){
            $n = random_int(1, 4);
            $rules = AccessRule::sample($n);
            for ($i = 0; $i < $n; $i++) {
                $team->rules()->attach($rules[$i]);
                $team->save();
            }
        }

        //Second run: Lock Groups to Rules
        $lock_groups = LockGroup::inRandomOrder()->get();
        /** @var LockGroup $lock_group */
        foreach ($lock_groups as $lock_group){
            $n = random_int(1, 4);
            $rules = AccessRule::sample($n);
            for ($i = 0; $i < $n; $i++) {
                $lock_group->rules()->attach($rules[$i]);
                $lock_group->save();
            }
        }
    }
}
