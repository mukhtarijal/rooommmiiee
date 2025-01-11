<?php

namespace App\Filament\Owner\Resources\UserResource\Pages;

use App\Filament\Owner\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function mount(): void
    {
        // Redirect ke halaman edit user yang sedang login
        Redirect::to(UserResource::getUrl('edit', ['record' => Auth::id()]));
    }
}
