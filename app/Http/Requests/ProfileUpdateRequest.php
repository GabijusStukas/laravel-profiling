<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTOs\ProfileUpdateDTO;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'answer' => ['required', 'max:255'],
            'question_id' => ['required', 'exists:profiling_questions,id'],
        ];
    }

    /**
     * @return ProfileUpdateDTO
     */
    public function toDTO(): ProfileUpdateDTO
    {
        $data = $this->validated();

        return new ProfileUpdateDTO(
            answer: $data['answer'],
            questionId: $data['question_id'],
            userId: $this->user()->id
        );
    }
}
