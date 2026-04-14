<?php

namespace App\Interfaces;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Support\Collection;

interface PollOptionRepositoryInterface {
    public function optionIntereastPercentage(Poll $poll): Collection;
    public function winnerOption(Poll $poll): PollOption;

}
