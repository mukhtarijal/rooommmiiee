<?php

namespace App\Filament\Owner\Resources;

use App\Filament\Owner\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Dasar')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required(),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique('users', 'email', ignoreRecord: true),

                        TextInput::make('password')
                            ->label('Password Baru')
                            ->password()
                            ->minLength(8)
                            ->confirmed()
                            ->dehydrated(fn ($state) => filled($state))
                            ->nullable(),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password Baru')
                            ->password()
                            ->minLength(8)
                            ->requiredWith('password')
                            ->dehydrated(false)
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Informasi Pribadi')
                    ->schema([
                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->nullable(),

                        TextInput::make('birth_place')
                            ->label('Tempat Lahir')
                            ->nullable(),

                        DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->nullable(),

                        Textarea::make('address')
                            ->label('Alamat')
                            ->nullable(),

                        Select::make('city_id')
                            ->label('Kota')
                            ->relationship('city', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        TextInput::make('job')
                            ->label('Pekerjaan')
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Informasi Kontak')
                    ->schema([
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->nullable(),
                    ]),

                Section::make('Foto Profil')
                    ->schema([
                        FileUpload::make('profile_photo')
                            ->label('Foto Profil')
                            ->image()
                            ->directory('user-profile')
                            ->imageEditor()
                            ->nullable(),
                    ]),
            ]);
    }

    public static function getBreadcrumb(): string
    {
        return 'Edit Profil'; // Ubah breadcrumb agar sesuai dengan konteks
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true; // Pastikan menu "User" tetap muncul di sidebar
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }


    public static function getNavigationUrl(): string
    {
        // Arahkan ke route index, yang akan redirect ke edit
        return self::getUrl('index');
    }

    public static function canCreate(): bool
    {
        // Nonaktifkan tombol "Create" karena user hanya bisa mengedit akun mereka sendiri
        return false;
    }

}
