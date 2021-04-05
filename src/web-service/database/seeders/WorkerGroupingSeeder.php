<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Worker;
use Exception;
use Illuminate\Database\Seeder;

class WorkerGroupingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $workers = Worker::inRandomOrder()->get();
        /** @var Worker $worker */
        foreach ($workers as $worker){
            $n = random_int(0, 4);
            $teams = Team::sample($n);
            for($i = 0; $i < $n; $i++){
                $worker->teams()->attach($teams[$i]);
                $worker->save();
            }
        }
    }
}
