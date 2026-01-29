<?php

namespace App\Filament\Resources\Addons\Pages;

use App\Filament\Resources\Addons\AddonResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAddon extends CreateRecord
{
    protected static string $resource = AddonResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
