<?php

namespace App\Filament\Admin\Resources\AdvertisementDurationResource\Pages;

use App\Filament\Admin\Resources\AdvertisementDurationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdvertisementDurations extends ListRecords
{
    protected static string $resource = AdvertisementDurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
