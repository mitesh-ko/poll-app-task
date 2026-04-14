<?php

namespace App\Services;

use App\Interfaces\PollAnswerRepositoryInterface;
use App\Models\Poll;
use App\Repositories\PollAnswerRepository;

class PollService
{
    protected $repository;

    public function __construct(
        protected PollAnswerRepositoryInterface $pollAnswerRepository = new PollAnswerRepository()
    )
    {}

    public function canAnswerOnPoll(Poll $poll): bool
    {
        $hasAnswered = $this->pollAnswerRepository->userAnswers($poll)->count();
        return !$hasAnswered && $poll->end_at > now();
    }
}