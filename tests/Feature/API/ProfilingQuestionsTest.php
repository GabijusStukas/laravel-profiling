<?php

namespace Tests\Feature\API;

use App\Models\User;
use App\Repositories\ProfilingQuestionsRepository;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProfilingQuestionsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function testGetProfilingQuestions(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('profiling-questions.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'question',
                        'options',
                        'answer',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }

    /**
     * @return void
     */
    public function testGetProfilingQuestionsException(): void
    {
        $user = User::factory()->create();

        $exceptionMessage = 'Test Exception';

        $this->mock(ProfilingQuestionsRepository::class)
            ->shouldReceive('getUserProfilingQuestions')
            ->andThrow(new Exception($exceptionMessage));

        $response = $this->actingAs($user)->getJson(route('profiling-questions.index'));

        $response->assertStatus(400)
            ->assertJson([
                'status' => 400,
                'success' => false,
                'error' => [
                    'code' => null,
                    'message' => $exceptionMessage
                ]
            ]);
    }

    /**
     * @return void
     */
    public function testGetProfilingQuestionsWhileUnauthorized(): void
    {
        $response = $this->getJson(route('profiling-questions.index'));

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }
}
