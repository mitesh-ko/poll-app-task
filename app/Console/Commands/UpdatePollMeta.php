<?php

namespace App\Console\Commands;

use App\DTOs\PollDataDTO;
use App\Interfaces\PollAnswerRepositoryInterface;
use App\Interfaces\PollOptionRepositoryInterface;
use App\Interfaces\PollRepositoryInterface;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:update-poll-meta')]
#[Description('Command description')]
class UpdatePollMeta extends Command
{
    public function __construct(
        protected PollRepositoryInterface $pollRepository,
        protected PollOptionRepositoryInterface $pollOptionRepository,
        protected PollAnswerRepositoryInterface $pollAnswerRepository
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $polls = $this->pollRepository->endedPollsNotHaveMeta();
        
        foreach($polls as $poll) {
            $winnerOption = $this->pollOptionRepository->winnerOption($poll);
            $meta =  PollDataDTO::verifyMetaData([
                'option_id' => $winnerOption->id,
                'ans_count' => $this->pollAnswerRepository->answerCount($poll),
            ]);
            $poll->update([
                'data' => $meta
            ]);
        }
    }
}
