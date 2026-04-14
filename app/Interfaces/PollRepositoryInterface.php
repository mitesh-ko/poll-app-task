<?php

namespace App\Interfaces;

use App\Models\Poll;

interface PollRepositoryInterface {
    public function firstPollWithOptions($slug): Poll;

    public function firstPoll($slug): Poll;
}
