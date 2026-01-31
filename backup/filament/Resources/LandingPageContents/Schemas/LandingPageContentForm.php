<?php

namespace App\Filament\Resources\LandingPageContents\Schemas;

use Filament\Schemas\Schema;

class LandingPageContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('key')
                    ->required()
                    ->unique(ignoreRecord: true),
                \Filament\Forms\Components\Select::make('type')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Long Text',
                        'image' => 'Image',
                        'json' => 'Complex Data',
                    ])
                    ->required()
                    ->live(),
                \Filament\Forms\Components\TextInput::make('content.value')
                    ->label('Content Value')
                    ->hidden(fn(callable $get) => $get('type') !== 'text'),
                \Filament\Forms\Components\Textarea::make('content.value')
                    ->label('Content Value')
                    ->hidden(fn(callable $get) => $get('type') !== 'textarea'),
                \Filament\Forms\Components\FileUpload::make('content.value')
                    ->label('Content Image')
                    ->image()
                    ->directory('landing-page')
                    ->hidden(fn(callable $get) => $get('type') !== 'image'),
                \Filament\Forms\Components\KeyValue::make('content.value')
                    ->label('Content JSON')
                    ->hidden(fn(callable $get) => $get('type') !== 'json'),
            ]);
    }
}
