<?php

namespace App\Events;

use App\Interfaces\PollAnswerRepositoryInterface;
use App\Interfaces\PollOptionRepositoryInterface;
use App\Models\Poll;
use App\Repositories\PollAnswerRepository;
use App\Repositories\PollOptionRepository;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PollAnswerAdded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $poll;
    protected $pollAnswerRepository;
    protected $pollOptionRepository;
    /**
     * Create a new event instance.
     */
    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
        $this->pollAnswerRepository = new PollAnswerRepository();
        $this->pollOptionRepository = new PollOptionRepository();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel($this->poll->slug),
        ];
    }

    public function broadcastWith()
    {
        return [
            'ansCount' => $this->pollAnswerRepository->answerCount($this->poll),
            'ansPercentage' => $this->pollOptionRepository->optionIntereastPercentage($this->poll)
        ];
    }
}
