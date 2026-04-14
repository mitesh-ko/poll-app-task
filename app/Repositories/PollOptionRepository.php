<?php

namespace App\Repositories;

use App\Interfaces\PollOptionRepositoryInterface;
use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Support\Collection;

class PollOptionRepository implements PollOptionRepositoryInterface
{
    /**
     * Get a poll details
     */
    public function optionIntereastPercentage(Poll $poll): Collection
    {
        return PollOption::select('option_text', 'percentage')->where('poll_id', $poll->id)->pluck('percentage', 'option_text');
    }

    public function winnerOption(Poll $poll): PollOption
    {
        return PollOption::where('poll_id', $poll->id)->orderBy('percentage', 'desc')->first();
    }
}
