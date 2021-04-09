<?php

namespace Database\Factories;

use App\Models\AccessRule;
use App\Models\Lock;
use App\Models\Log;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Log::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event' => $this->faker->boolean(90) ? 'entry' : 'other',
            'action' => $this->faker->boolean ? 'allow' : 'forbid',
            'worker_id' => Worker::random()->id,
            'lock_id' => Lock::random()->id,
            'rule_id' => $this->faker->boolean ? AccessRule::random()->id : null,
        ];
    }
}
