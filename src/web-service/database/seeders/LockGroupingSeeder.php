<?php

namespace Database\Seeders;

use App\Models\Lock;
use App\Models\LockGroup;
use Illuminate\Database\Seeder;

class LockGroupingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locks = Lock::inRandomOrder()->get();
        /** @var Lock $lock */
        foreach ($locks as $lock){
            $n = random_int(0, 4);
            $groups = LockGroup::sample($n);
            for ($i = 0; $i < $n; $i++) {
                $lock->groups()->attach($groups[$i]);
                $lock->save();
            }
        }
    }
}
