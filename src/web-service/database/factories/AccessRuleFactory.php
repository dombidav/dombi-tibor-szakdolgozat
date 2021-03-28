<?php

namespace Database\Factories;

use App\Models\AccessRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccessRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            //TODO: Complete Definition
        ];
    }
}
