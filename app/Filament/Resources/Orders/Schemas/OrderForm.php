<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                \Filament\Forms\Components\Select::make('partnership_id')
                    ->relationship('partnership', 'outlet_name')
                    ->searchable(),
                \Filament\Forms\Components\Select::make('package_id')
                    ->relationship('package', 'name')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('shipping_cost')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),
                \Filament\Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'processing' => 'Processing',
                        'shipping' => 'Shipping',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                \Filament\Forms\Components\TextInput::make('tracking_number')
                    ->label('Resi / Tracking Number'),
                \Filament\Forms\Components\TextInput::make('xendit_invoice_id')
                    ->disabled(),
                \Filament\Forms\Components\Textarea::make('note')
                    ->columnSpanFull(),

                Section::make('Order Items')
                    ->schema([
                        \Filament\Forms\Components\Repeater::make('orderItems')
                            ->relationship()
                            ->schema([
                                \Filament\Forms\Components\Select::make('addon_id')
                                    ->relationship('addon', 'name')
                                    ->required(),
                                \Filament\Forms\Components\TextInput::make('quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                                \Filament\Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                            ])
                            ->columns(3)
                    ])
            ]);
    }
}
