<?php

namespace App\Filament\Owner\Resources\UserResource\Pages;

use App\Filament\Owner\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->hidden(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Pastikan user hanya bisa mengedit akun mereka sendiri
        if ($this->record->id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit akun ini.');
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Pastikan user hanya bisa mengedit akun mereka sendiri
        if ($this->record->id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit akun ini.');
        }

        // Hash password baru jika diisi
        if (isset($data['password']) && filled($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Hapus field password jika tidak diisi
            unset($data['password']);
        }

        // Hapus field konfirmasi password karena tidak perlu disimpan
        unset($data['password_confirmation']);

        return $data;
    }
}
