<?php

namespace App\Interfaces;

use App\Models\Poll;

interface PollOptionRepositoryInterface {
    public function optionIntereastPercentage(Poll $poll);

}
