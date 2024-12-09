<?php

declare(strict_types=1);

namespace App\DTOs;

class ProfileUpdateDTO
{
    /**
     * @param string $answer
     * @param int $questionId
     * @param int $userId
     */
    public function __construct(private string $answer, private int $questionId, private int $userId)
    {
    }

    /**
     * @return string
     */
    public function getAnswer(): string
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
