<?php

namespace App\Filament\Resources\ShippingRates\Schemas;

use Filament\Schemas\Schema;

class ShippingRateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('destination_city')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('price_per_kg')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                \Filament\Forms\Components\TextInput::make('minimum_weight')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->suffix('kg'),
            ]);
    }
}
