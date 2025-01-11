<?php

namespace App\Filament\Owner\Pages\Auth;

use App\Models\City;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Support\Facades\Hash;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Wizard::make([
                            Wizard\Step::make('Informasi Dasar')
                                ->schema([
                                    $this->getNameFormComponent(),
                                    $this->getEmailFormComponent(),
                                    $this->getPasswordFormComponent(),
                                    $this->getPasswordConfirmationFormComponent(),
                                ]),

                            Wizard\Step::make('Informasi Kontak')
                                ->schema([
                                    TextInput::make('phone')
                                        ->label('Phone')
                                        ->placeholder('Phone')
                                        ->autocomplete('phone')
                                        ->required(),

                                    TextInput::make('address')
                                        ->label('Alamat')
                                        ->placeholder('Alamat')
                                        ->autocomplete('address')
                                        ->required(),

                                    Select::make('city_id')
                                        ->label('Kota')
                                        ->placeholder('Pilih Kota')
                                        ->options(
                                            City::all()->pluck('name', 'id')
                                        )
                                        ->searchable()
                                        ->required(),
                                ]),
                        ])
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function handleRegistration(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address'],
            'city_id' => $data['city_id'],
        ]);
        $user->assignRole('owner');
        return $user;
    }
}
