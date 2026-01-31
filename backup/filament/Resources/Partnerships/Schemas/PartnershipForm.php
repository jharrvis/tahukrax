<?php

namespace App\Filament\Resources\Partnerships\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PartnershipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                \Filament\Forms\Components\Select::make('package_id')
                    ->relationship('package', 'name')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('partnership_code')
                    ->required()
                    ->unique(ignoreRecord: true),
                \Filament\Forms\Components\TextInput::make('outlet_name')
                    ->required(),
                Section::make('Shipping / Outlet Info')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('recipient_name')
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('phone_number')
                            ->tel()
                            ->required(),
                        \Filament\Forms\Components\Textarea::make('address')
                            ->required()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\TextInput::make('city')
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('province')
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('postal_code')
                            ->required(),
                    ]),
                \Filament\Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'suspended' => 'Suspended',
                        'closed' => 'Closed',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }
}
