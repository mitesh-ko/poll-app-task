<?php

namespace App\Interfaces;

use App\Models\Poll;
use App\Models\PollAnswer;
use Illuminate\Database\Eloquent\Collection;

interface PollAnswerRepositoryInterface {
    public function userAnswers(Poll $poll): Collection;
    public function storePollAnswer(Poll $poll, array $answers): bool;
    public function updateAnswerPercentage(Poll $poll);
    public function answerCount(Poll $poll): int;
}
