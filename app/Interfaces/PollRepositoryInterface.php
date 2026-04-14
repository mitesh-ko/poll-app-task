<?php

namespace App\Interfaces;

use App\Models\Poll;
use Illuminate\Database\Eloquent\Collection;

interface PollRepositoryInterface {
    public function firstPollWithOptions($slug): Poll;

    public function firstPoll($slug): Poll;

    public function endedPollsNotHaveMeta(): Collection;
}
