<?php

namespace App\Filament\Resources\Polls\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PollForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->required(),
                DateTimePicker::make('end_at')
                    ->required(),
                Toggle::make('is_multichoice')
                    ->required()
                    ->default(0),

                Repeater::make('options')
                    ->relationship()
                    ->schema([
                        TextInput::make('option_text')->label('Option')->required(),
                    ])
                    ->defaultItems(2)
                    ->minItems(2)
                    ->reorderable(false)
                    ->addActionLabel('Add Option')
            ]);
    }
}
