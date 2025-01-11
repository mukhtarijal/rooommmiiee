<?php

namespace App\Filament\Admin\Resources\SewaResource\Pages;

use App\Filament\Admin\Resources\SewaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSewas extends ListRecords
{
    protected static string $resource = SewaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
