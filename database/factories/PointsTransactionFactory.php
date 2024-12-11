<?php

namespace Database\Factories;

use App\Models\PointsTransaction;
use App\Models\ProfilingQuestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProfilingQuestion>
 */
class PointsTransactionFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = PointsTransaction::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'points' => $this->faker->numberBetween(1, 1000),
            'claimed_at' => $this->faker->dateTime(),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}
