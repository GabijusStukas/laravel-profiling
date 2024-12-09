<?php

namespace Database\Seeders;

use App\Models\ProfilingQuestion;
use Illuminate\Database\Seeder;

class ProfilingQuestionsSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        ProfilingQuestion::query()->create([
            'question' => 'Gender',
            'type' => 'single-choice',
            'options' => ['Male', 'Female'],
        ]);

        ProfilingQuestion::query()->create([
            'question' => 'Date of birth',
            'type' => 'date',
            'options' => null,
        ]);
    }
}
