<?php

namespace App\Filament\Admin\Resources\AdvertisementDurationResource\Pages;

use App\Filament\Admin\Resources\AdvertisementDurationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdvertisementDuration extends EditRecord
{
    protected static string $resource = AdvertisementDurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
