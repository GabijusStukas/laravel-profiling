<?php

declare(strict_types=1);

namespace App\Services\Profiling\Handlers;

use App\DTOs\ProfileUpdateDTO;
use App\Exceptions\ProfileUpdateException;
use App\Models\ProfilingQuestion;
use App\Repositories\PointsTransactionRepository;
use App\Repositories\UserProfileRepository;
use Illuminate\Support\Facades\Cache;
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

        $lock = Cache::lock('profile_update_lock_' . $dto->getUserId(), 10);
        if (!$lock->get()) {
            throw new ProfileUpdateException('Profile update is currently in progress. Please try again later.');
        }

        try {
            DB::transaction(function () use ($question, $dto) {
                $this->updateProfile($question, $dto);
                $this->transactionRepository->createNewTransaction($dto->getUserId());
            });
        } finally {
            $lock->release();
        }

    }

    /**
     * @param ProfilingQuestion $question
     * @param ProfileUpdateDTO $dto
     * @return void
     */
    abstract protected function updateProfile(ProfilingQuestion $question, ProfileUpdateDTO $dto): void;
}
