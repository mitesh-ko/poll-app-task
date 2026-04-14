<?php

namespace App\Filament\Resources\Polls\Tables;

use App\Filament\Resources\Polls\Pages\ResultPoll;
use App\Models\Poll;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PollsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('end_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),

                Action::make('view_results')
                ->label('View Result')
                ->url(fn (Poll $record): string => ResultPoll::getUrl(['record' => $record->id], 'results')), 

                Action::make('copyLink')
                ->label('Poll Link')
                ->icon('heroicon-o-clipboard')
                ->action(function (Model $record) {
                    Notification::make()
                        ->title('Link copied to clipboard')
                        ->success()
                        ->send();
                })
                ->extraAttributes(function (Model $record) {
                    $url = url('/poll/' . $record->slug);
                    
                    return [
                        'onclick' => "navigator.clipboard.writeText('{$url}')",
                    ];
                }),
            ])
            ->defaultSort('id', 'desc') 
            ->toolbarActions([
            ]);
    }
}
