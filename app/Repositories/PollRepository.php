<?php

namespace App\Repositories;

use App\Interfaces\PollRepositoryInterface;
use App\Models\Poll;
use Illuminate\Database\Eloquent\Collection;

class PollRepository implements PollRepositoryInterface
{
    /**
     * Get a poll details
     */
    public function firstPollWithOptions($slug): Poll
    {
        return Poll::with('options:id,poll_id,option_text')->where('slug', $slug)->select([
            'id',
            'is_multichoice',
            'slug',
            'question',
            'end_at'
        ])->firstOrFail();
    }

    /**
     * Get a poll details
     */
    public function firstPoll($slug): Poll
    {
        return Poll::where('slug', $slug)->firstOrFail();
    }

    public function endedPollsNotHaveMeta(): Collection
    {
        return Poll::where('end_at', '<', now())->whereNull('data')->get();
    }
}
