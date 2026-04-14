<?php

namespace App\Repositories;

use App\Interfaces\PollOptionRepositoryInterface;
use App\Models\Poll;
use App\Models\PollOption;

class PollOptionRepository implements PollOptionRepositoryInterface
{
    /**
     * Get a poll details
     */
    public function optionIntereastPercentage(Poll $poll)
    {
        return PollOption::select('option_text', 'percentage')->where('poll_id', $poll->id)->pluck('percentage', 'option_text');
    }
}
