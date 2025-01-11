<?php

namespace App\Filament\Admin\Resources\KostResource\Pages;

use App\Filament\Admin\Resources\KostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKosts extends ListRecords
{
    protected static string $resource = KostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
