<?php

namespace Database\Factories;

use App\Models\Lock;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'device_key' => $this->faker->boolean(80) ? Str::random(10) : null,
            'status' => $this->faker->numberBetween(0,2),
        ];
    }
}
