<?php

namespace Tests\Feature\API;

use App\Models\ProfilingQuestion;
use App\Models\User;
use App\Services\User\ProfileService;
use Exception;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Tests\Traits\ProfilingQuestionMocker;

class UserProfileTest extends TestCase
{
    use DatabaseTransactions;
    use ProfilingQuestionMocker;

    /**
     * @param string $type
     * @param mixed $answer
     * @return void
     * @throws Exception
     */
    #[DataProvider('dataProviderValidAnswers')]
    public function testAnswerQuestionSuccessfully(string $type, mixed $answer): void
    {
        $user = User::factory()->create();
        $question = $this->createQuestion($type);

        $response = $this->actingAs($user)->postJson(route('user-profile.store'), [
            'answer' => $answer,
            'question_id' => $question->id,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'success' => true,
                'data' => null,
            ]);
    }

    /**
     * @param string $type
     * @param mixed $answer
     * @return void
     * @throws Exception
     */
    #[DataProvider('dataProviderInvalidAnswers')]
    public function testQuestionAnswerNotValid(string $type, mixed $answer): void
    {
        $user = User::factory()->create();
        $question = $this->createQuestion($type);

        $response = $this->actingAs($user)->postJson(route('user-profile.store'), [
            'answer' => $answer,
            'question_id' => $question->id,
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'status' => 400,
                'success' => false,
            ]);
    }

    /**
     * @return void
     */
    public function testUpdateUserProfileValidationError(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('user-profile.store'), [
            'answer' => '',
            'question_id' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['answer', 'question_id']);
    }

    /**
     * @return void
     */
    public function testUpdateUserProfileUnauthorized(): void
    {
        $response = $this->postJson(route('user-profile.store'), [
            'answer' => ['Yes', 'No'],
            'question_id' => 1,
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testUpdateUserProfileException(): void
    {
        $user = User::factory()->create();
        $question = $this->createQuestion(ProfilingQuestion::TYPE_SINGLE_CHOICE);

        $exceptionMessage = 'Test Exception';

        $this->mock(ProfileService::class)
            ->shouldReceive('updateProfile')
            ->andThrow(new Exception($exceptionMessage));

        $response = $this->actingAs($user)->postJson(route('user-profile.store'), [
            'answer' => ['Yes', 'No'],
            'question_id' => $question->id,
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'status' => 400,
                'success' => false,
                'error' => [
                    'code' => null,
                    'message' => $exceptionMessage,
                ],
            ]);
    }

    /**
     * @throws Exception
     */
    public static function dataProviderValidAnswers(): array
    {
        return [
            [ProfilingQuestion::TYPE_SINGLE_CHOICE, 'Option 1'],
            [ProfilingQuestion::TYPE_MULTIPLE_CHOICE, ['Option 1', 'Option 2']],
            [ProfilingQuestion::TYPE_DATE, now()->toDateString()],
            [ProfilingQuestion::TYPE_DATE, now()->toDateTimeString()],
            [ProfilingQuestion::TYPE_OPEN, 'Some answer'],
        ];
    }

    /**
     * @throws Exception
     */
    public static function dataProviderInvalidAnswers(): array
    {
        $faker = Factory::create();

        return [
            [ProfilingQuestion::TYPE_SINGLE_CHOICE, $faker->word()],
            [ProfilingQuestion::TYPE_MULTIPLE_CHOICE, [$faker->word(), $faker->word()]],
            [ProfilingQuestion::TYPE_MULTIPLE_CHOICE, ['Option 1', $faker->word()]],
            [ProfilingQuestion::TYPE_MULTIPLE_CHOICE, ['Option 1', $faker->numberBetween(100, 1000)]],
            [ProfilingQuestion::TYPE_MULTIPLE_CHOICE, $faker->sentence()],
            [ProfilingQuestion::TYPE_DATE, $faker->word()],
            [ProfilingQuestion::TYPE_OPEN, $faker->numberBetween(100, 1000)],
        ];
    }
}
