<?php

namespace App\Filament\Owner\Resources\ChatResource\Pages;

use App\Filament\Owner\Resources\ChatResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateChat extends CreateRecord
{
    protected static string $resource = ChatResource::class;
}
