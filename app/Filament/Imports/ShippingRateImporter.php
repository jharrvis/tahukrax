<?php

namespace App\Filament\Imports;

use App\Models\ShippingRate;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class ShippingRateImporter extends Importer
{
    protected static ?string $model = ShippingRate::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('destination_city')
                ->requiredMapping()
                ->rules(['required', 'string']),
            ImportColumn::make('price_per_kg')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'numeric', 'min:0']),
            ImportColumn::make('minimum_weight')
                ->numeric()
                ->rules(['nullable', 'numeric', 'min:0']),
        ];
    }

    public function resolveRecord(): ShippingRate
    {
        return ShippingRate::firstOrNew([
            'destination_city' => $this->data['destination_city'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your shipping rate import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
