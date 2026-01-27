<?php

namespace App\Filament\Resources\Bonuses\Schemas;

use Filament\Schemas\Schema;

class BonusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('name')
                    ->required(),
                \Filament\Forms\Components\Textarea::make('description'),
                \Filament\Forms\Components\TextInput::make('duration_days')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->suffix('days'),
                \Filament\Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
