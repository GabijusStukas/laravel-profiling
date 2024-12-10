<?php

declare(strict_types=1);

namespace App\Services\Profiling\Handlers;

use App\DTOs\ProfileUpdateDTO;
use App\Exceptions\ProfileUpdateException;
use App\Models\ProfilingQuestion;
use App\Repositories\PointsTransactionRepository;
use App\Repositories\UserProfileRepository;
use Illuminate\Support\Facades\DB;

abstract class AbstractQuestionHandler
{
    /**
     * @param UserProfileRepository $profileRepository
     * @param PointsTransactionRepository $transactionRepository
     */
    public function __construct(
        protected UserProfileRepository $profileRepository,
        protected PointsTransactionRepository $transactionRepository
    ) {
    }

    /**
     * @param ProfilingQuestion $question
     * @param ProfileUpdateDTO $dto
     * @return void
     * @throws ProfileUpdateException
     */
    public function handle(ProfilingQuestion $question, ProfileUpdateDTO $dto): void
    {
        if (empty($dto->getAnswer())) {
            throw new ProfileUpdateException('Answer cannot be empty');
        }

        DB::transaction(function () use ($question, $dto) {
            $this->isAnswerValid($question, $dto);
            $this->profileRepository->save($dto);
            $this->transactionRepository->createNewTransaction($dto->getUserId());
        });
    }

    /**
     * @param ProfilingQuestion $question
     * @param ProfileUpdateDTO $dto
     * @return void
     */
    abstract protected function isAnswerValid(ProfilingQuestion $question, ProfileUpdateDTO $dto): void;
}
