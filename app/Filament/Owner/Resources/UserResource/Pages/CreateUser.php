<?php

namespace App\Filament\Owner\Resources\UserResource\Pages;

use App\Filament\Owner\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
