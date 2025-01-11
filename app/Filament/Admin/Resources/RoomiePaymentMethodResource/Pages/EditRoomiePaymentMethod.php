<?php

namespace App\Filament\Admin\Resources\RoomiePaymentMethodResource\Pages;

use App\Filament\Admin\Resources\RoomiePaymentMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRoomiePaymentMethod extends EditRecord
{
    protected static string $resource = RoomiePaymentMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
