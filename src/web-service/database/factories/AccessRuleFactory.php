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
        $days = [0,1,2,3,4,5,6];
        for ($i = 0; $i < $this->faker->numberBetween(0,6); $i++){
            unset($days[$this->faker->numberBetween(0,count($days))]);
            $days = array_values($days);
        }

        $object = $this->faker->boolean
            ? [
                'onDays' => $days,
                'from' => $this->faker->dateTime()->format('H:i:s.v'),
                'until' => $this->faker->dateTime()->format('H:i:s.v'),
                'action' => $this->faker->boolean ? 'allow' : 'forbid'
            ]
            : [
              'on' => $this->faker->dateTimeBetween('now', '+3 months') ->format('Y-m-d'),
              'action' => $this->faker->boolean ? 'allow' : 'forbid'
            ];
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->boolean(60) ? $this->faker->sentences(3, true) : null,
            'definition' => $object
        ];
    }
}
