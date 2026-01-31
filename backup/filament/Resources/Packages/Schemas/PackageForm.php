<?php

namespace App\Filament\Resources\Packages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Paket')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                FileUpload::make('image_url')
                    ->label('Gambar Paket')
                    ->image()
                    ->directory('packages')
                    ->disk('public')
                    ->visibility('public')
                    ->imagePreviewHeight('150'),
                TagsInput::make('features')
                    ->label('Fitur/Fasilitas')
                    ->placeholder('Tambah fitur...'),
                Textarea::make('description')
                    ->label('Deskripsi')
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
