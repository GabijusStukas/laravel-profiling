<?php

declare(strict_types=1);

namespace App\DTOs;

class ProfileUpdateDTO
{
    /**
     * @param mixed $answer
     * @param int $questionId
     * @param int $userId
     */
    public function __construct(private mixed $answer, private int $questionId, private int $userId)
    {
    }

    /**
     * @return mixed
     */
    public function getAnswer(): mixed
    {
        return $this->answer;
    }

    /**
     * @return int
     */
    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
