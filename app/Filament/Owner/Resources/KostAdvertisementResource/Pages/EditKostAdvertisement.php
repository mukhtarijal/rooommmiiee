<?php

namespace App\Filament\Owner\Resources\KostAdvertisementResource\Pages;

use App\Filament\Owner\Resources\KostAdvertisementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKostAdvertisement extends EditRecord
{
    protected static string $resource = KostAdvertisementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
