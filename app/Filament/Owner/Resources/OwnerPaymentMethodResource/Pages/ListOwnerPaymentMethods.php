<?php

namespace App\Filament\Owner\Resources\OwnerPaymentMethodResource\Pages;

use App\Filament\Owner\Resources\OwnerPaymentMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOwnerPaymentMethods extends ListRecords
{
    protected static string $resource = OwnerPaymentMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
