<?php

namespace App\Filament\Owner\Resources\KostResource\Pages;

use App\Filament\Owner\Resources\KostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKost extends EditRecord
{
    protected static string $resource = KostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

}
