<?php

namespace App\Repositories;

use App\Interfaces\PollAnswerRepositoryInterface;
use App\Models\Poll;
use App\Models\PollAnswer;
use Illuminate\Database\Eloquent\Collection;

class PollAnswerRepository implements PollAnswerRepositoryInterface
{
    public function userAnswers(Poll $poll): Collection
    {
        return PollAnswer::where('poll_id', $poll->id)->where(function ($query) {
            $query->where('user_id', auth()->id())->orWhere('ip_address', request()->ip());
        })->select(['id', 'poll_option_id'])->get();
    }

    public function storePollAnswer(Poll $poll, array $answers): bool
    {
        $ansData = [
            'user_id' => auth()->id(), // auth user id or null
            'poll_id' => $poll->id,
            'ip_address' => request()->ip(),
        ];
        $storeData = [];
        foreach ($answers as $value) {
            $ansData['poll_option_id'] = $value;
            $ansData['created_at'] = now();
            $ansData['updated_at'] = now();
            $storeData[] = $ansData;
        }
        return PollAnswer::insert($storeData);
    }

    public function updateAnswerPercentage(Poll $poll)
    {
        $options = $poll->options()->get();
        $totalAnswers = $this->answerCount($poll);
        foreach ($options as $option) {
            $option->percentage = round(($option->answers()->count() / $totalAnswers) * 100, 2);
            $option->save();
        }
    }

    /**
     * total users answered
     */
    public function answerCount(Poll $poll): int 
    {
        return PollAnswer::where('poll_id', $poll->id)->distinct('user_id')->distinct('ip_address')->count();
    }
}
