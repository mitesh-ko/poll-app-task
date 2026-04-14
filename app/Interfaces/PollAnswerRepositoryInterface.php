<?php

namespace App\Interfaces;

use App\Models\Poll;

interface PollAnswerRepositoryInterface {
    public function canAnswerOnPoll(Poll $poll): bool;
    public function userAnswers(Poll $poll);
    public function storePollAnswer(Poll $poll, array $answers);
    public function updateAnswerPercentage(Poll $poll);
    public function answerCount(Poll $poll): int;
}
