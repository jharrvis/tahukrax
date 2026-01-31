<?php

namespace App\Filament\Resources\Addons\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AddonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Add-on')
                    ->required(),
                Select::make('type')
                    ->label('Tipe')
                    ->options([
                        'car' => 'Unit RC',
                        'track' => 'Perlengkapan Arena',
                        'accessory' => 'Aksesoris & Sparepart',
                        'other' => 'Lainnya',
                    ])
                    ->required(),
                FileUpload::make('image_url')
                    ->label('Gambar')
                    ->image()
                    ->directory('addons')
                    ->disk('public')
                    ->visibility('public')
                    ->imagePreviewHeight('150'),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->placeholder('Deskripsi lengkap mengenai add-on ini...')
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->label('Harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),

                TextInput::make('weight_kg')
                    ->label('Berat')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->suffix('kg'),
            ]);
    }
}
