<?php

namespace App\Filament\Admin\Resources\KostAdvertisementResource\Pages;

use App\Filament\Admin\Resources\KostAdvertisementResource;
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
    protected function afterSave(): void
    {
        // Simpan data is_premium ke tabel kost
        $this->record->kost->update([
            'is_premium' => $this->form->getState()['kost']['is_premium'],
        ]);
    }
}
