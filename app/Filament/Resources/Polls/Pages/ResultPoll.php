<?php

namespace App\Filament\Resources\Polls\Pages;

use App\Filament\Resources\Polls\PollResource;
use App\Models\PollAnswer;
use App\Models\PollOption;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use League\Uri\Builder;

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
        return [
            'poll' => $this->record,
            'ansCount' => PollAnswer::answerCount($this->record->id),
            'pollOptions' => PollOption::where('poll_id', $this->record->id)->get(),
        ];
    }
}
