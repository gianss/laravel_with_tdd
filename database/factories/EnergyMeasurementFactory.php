<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\User;

class EnergyMeasurementFactory extends Factory
{
    protected $model = \App\Models\EnergyMeasurement::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'energy_value' => decbin($this->faker->numberBetween(500, 1023)),
            'measurement_datetime' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
