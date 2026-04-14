<?php

namespace App\Filament\Resources\Polls\Pages;

use App\Filament\Resources\Polls\PollResource;
use App\Repositories\PollAnswerRepository;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class ResultPoll extends Page
{
    use InteractsWithRecord;

    protected static string $resource = PollResource::class;

    protected static ?string $title = 'Poll Result';


    protected string $view = 'filament.resources.polls.pages.result-poll';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function getViewData(): array {
        $pollAnswerRepository = new PollAnswerRepository();
        return [
            'poll' => $this->record,
            'ansCount' => $pollAnswerRepository->answerCount($this->record),
            'pollOptions' => $this->record->options()->get()
        ];
    }
}
