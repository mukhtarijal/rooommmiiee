<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                            ->label('Password')
                            ->required()
                            ->hiddenOn('edit'),

                        Select::make('roles')
                            ->label('Role')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload()
                            ->required(),
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


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email'),
                TextColumn::make('phone')
                    ->label('Nomor Telepon'),
                TextColumn::make('roles.name')
                    ->label('Role')
                    ->formatStateUsing(fn ($record) => $record->getRoleNames()->implode(', ')),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'owner' => 'Owner',
                        'admin' => 'Admin',
                        'tenant' => 'Tenant',
                    ])
                    ->relationship('roles', 'name')
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
