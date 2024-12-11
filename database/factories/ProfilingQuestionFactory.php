<?php

namespace Database\Factories;

use App\Models\ProfilingQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProfilingQuestion>
 */
class ProfilingQuestionFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = ProfilingQuestion::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence,
            'type' => $this->faker->randomElement(ProfilingQuestion::TYPES),
            'options' => $this->faker->words(4),
        ];
    }
}
