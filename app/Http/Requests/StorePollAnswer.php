<?php

namespace App\Http\Requests;

use App\Interfaces\PollAnswerRepositoryInterface;
use App\Interfaces\PollRepositoryInterface;
use App\Services\PollService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StorePollAnswer extends FormRequest
{
    protected $pollService;

    public function __construct(
        protected PollRepositoryInterface $pollRepository,
        protected PollAnswerRepositoryInterface $pollAnswerRepository
    ) {
        $this->pollService = new PollService();
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        foreach (request()->all() as $key => $value) {
            $rules[$key] = 'max:255|exists:poll_options,id';
            $messages["{$key}.exists"] = 'The selected option is invalid for the poll.';
            $messages["{$key}.max"] = 'The selected option is too long.';
        }
        return $rules;
    }

    public function messages(): array
    {
        foreach (request()->all() as $key => $value) {
            $messages["{$key}.exists"] = 'The selected option is invalid for the poll.';
            $messages["{$key}.max"] = 'The selected option is too long.';
        }
        return $messages;
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $slug = $this->route('slug');
            $poll = $poll = $this->pollRepository->firstPoll($slug);
            
            $canAns = $this->pollService->canAnswerOnPoll($poll);;

            if (!$canAns) {
                $validator->errors()->add(
                    'poll_id', 'You have already answered on this poll.'
                );
            }
        });
    }
}
