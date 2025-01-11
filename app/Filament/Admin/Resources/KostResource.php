<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KostResource\Pages;
use App\Filament\Owner\Resources\KostResource\RelationManagers;
use App\Models\Kost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class KostResource extends Resource
{
    protected static ?string $model = Kost::class;
    // Nonaktifkan fitur create
    public static function canCreate(): bool
    {
        return false;
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make()
                    ->steps([
                        Forms\Components\Wizard\Step::make('Status Kost')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status Kost')
                                    ->native(false)
                                    ->required()
                                    ->options([
                                        'pending' => '⏳ Pending',
                                        'rejected' => '❌ Tolak',
                                        'approved' => '✅ Setujui',
                                        'incomplete' => '⚠️ Belum Lengkap',
                                    ])
                                    ->default('pending')
                                    ->placeholder('Pilih status kost')
                                    ->helperText('Tentukan status kost ini.')
                                    ->columnSpan(2),

                                Forms\Components\Fieldset::make('Pengaturan Premium')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_premium')
                                            ->label('Kost Premium')
                                            ->required()
                                            ->default(false)
                                            ->inline()
                                            ->helperText('Centang jika kost ini adalah kost premium.'),
                                        ])
                                    ]),
                        Forms\Components\Wizard\Step::make('Informasi Dasar')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Kost')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $state, callable $set) => $set('slug', Str::slug($state)))
                                    ->maxLength(255)
                                    ->placeholder('Masukkan nama kost')
                                    ->helperText('Contoh: Kost Mawar Indah')
                                    ->disabled(fn ($operation) => $operation === 'edit'),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique('kosts', 'slug', ignoreRecord: true)
                                    ->placeholder('Slug akan dihasilkan otomatis')
                                    ->helperText('Slug digunakan untuk URL.')
                                    ->disabled(fn ($operation) => $operation === 'edit'),

                                Forms\Components\Hidden::make('owner_id')
                                    ->default(auth()->id())
                                    ->disabled()
                                    ->required(),

                                Forms\Components\Select::make('gender')
                                    ->label('Jenis Kelamin')
                                    ->native(false)
                                    ->options([
                                        'L' => 'Laki-Laki',
                                        'P' => 'Perempuan',
                                    ])
                                    ->required()
                                    ->placeholder('Pilih jenis kelamin')
                                    ->helperText('Pilih jenis kelamin yang diperbolehkan untuk penghuni kost.')
                                    ->disabled(fn ($operation) => $operation === 'edit'),

                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi')
                                    ->required()
                                    ->placeholder('Masukkan deskripsi kost')
                                    ->helperText('Jelaskan fasilitas dan keunggulan kost Anda.')
                                    ->columnSpanFull()
                                    ->disabled(fn ($operation) => $operation === 'edit'),
                            ]),

                        Forms\Components\Wizard\Step::make('Detail Kamar')
                            ->schema([
                                Forms\Components\TextInput::make('year_established')
                                    ->label('Tahun Berdiri')
                                    ->numeric()
                                    ->required()
                                    ->placeholder('Masukkan tahun berdiri')
                                    ->helperText('Contoh: 2020')
                                    ->disabled(fn ($operation) => $operation === 'edit'),

                                Forms\Components\TextInput::make('room_size')
                                    ->label('Ukuran Kamar')
                                    ->numeric()
                                    ->required()
                                    ->suffix('m²')
                                    ->placeholder('Masukkan ukuran kamar')
                                    ->helperText('Contoh: 20')
                                    ->disabled(fn ($operation) => $operation === 'edit'),

                                Forms\Components\TextInput::make('capacity')
                                    ->label('Kapasitas Kamar')
                                    ->numeric()
                                    ->required()
                                    ->placeholder('Masukkan kapasitas kamar')
                                    ->helperText('Contoh: 2 (untuk 2 orang)')
                                    ->disabled(fn ($operation) => $operation === 'edit'),

                                Forms\Components\TextInput::make('available_rooms')
                                    ->label('Kamar Tersedia')
                                    ->numeric()
                                    ->required()
                                    ->placeholder('Masukkan jumlah kamar tersedia')
                                    ->helperText('Contoh: 10')
                                    ->disabled(fn ($operation) => $operation === 'edit'),
                            ]),

                        Forms\Components\Wizard\Step::make('Lokasi')
                            ->schema([
                                Forms\Components\Textarea::make('address')
                                    ->label('Alamat')
                                    ->required()
                                    ->placeholder('Masukkan alamat lengkap kost')
                                    ->helperText('Contoh: Jl. Mawar Indah No. 10, Jakarta')
                                    ->columnSpanFull()
                                    ->disabled(fn ($operation) => $operation === 'edit'),

                                Forms\Components\Select::make('city_id')
                                    ->label('Kota')
                                    ->relationship('city', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->placeholder('Pilih kota')
                                    ->helperText('Pilih kota tempat kost berada.')
                                    ->disabled(fn ($operation) => $operation === 'edit'),

                                Forms\Components\TextInput::make('latitude')
                                    ->label('Latitude')
                                    ->numeric()
                                    ->required()
                                    ->placeholder('Masukkan latitude')
                                    ->helperText('Contoh: -6.175392')
                                    ->disabled(fn ($operation) => $operation === 'edit'),

                                Forms\Components\TextInput::make('longitude')
                                    ->label('Longitude')
                                    ->numeric()
                                    ->required()
                                    ->placeholder('Masukkan longitude')
                                    ->helperText('Contoh: 106.827153')
                                    ->disabled(fn ($operation) => $operation === 'edit'),
                            ]),

                        Forms\Components\Wizard\Step::make('Fasilitas dan Aturan')
                            ->schema([
                                Forms\Components\CheckboxList::make('facilities')
                                    ->label('Fasilitas')
                                    ->relationship('facilities', 'name')
                                    ->columns(2) // Menampilkan dalam 2 kolom
                                    ->columnSpanFull()
                                    ->disabled(fn ($operation) => $operation === 'edit'),

                                Forms\Components\CheckboxList::make('rules')
                                    ->label('Aturan')
                                    ->relationship('rules', 'rule')
                                    ->columns(2) // Menampilkan dalam 2 kolom
                                    ->columnSpanFull()
                                    ->disabled(fn ($operation) => $operation === 'edit'),
                            ]),
                    ])
                    ->skippable()
                    ->columnSpan(2)
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kost')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('owner.name')
                    ->label('Pemilik')
                    ->limit(35)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        // Tampilkan tooltip dengan teks lengkap saat di-hover
                        $state = $column->getState();
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    })
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('city.name')
                    ->label('Kota')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('available_rooms')
                    ->label('Kamar Tersedia')
                    ->numeric()
                    ->alignment('center'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'danger' => 'rejected',
                        'success' => 'approved',
                        'secondary' => 'incomplete',
                    ])
                    ->alignment('center')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('is_premium')
                    ->label('Premium?')
                    ->formatStateUsing(fn ($state) => $state ? 'Iya' : 'Tidak')
                    ->colors([
                        'success' => fn ($state) => $state,
                        'secondary' => fn ($state) => !$state,
                    ])
                    ->alignment('center'),

            ])
            ->filters([
                // Filter sesuai status
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'rejected' => 'Ditolak',
                        'approved' => 'Disetujui',
                        'incomplete' => 'Belum Lengkap',
                    ]),

                // Filter premium atau tidak
                SelectFilter::make('is_premium')
                    ->label('Premium?')
                    ->options([
                        true => 'Iya',
                        false => 'Tidak',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DurationsRelationManager::class,
            RelationManagers\PhotosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKosts::route('/'),
            'create' => Pages\CreateKost::route('/create'),
            'edit' => Pages\EditKost::route('/{record}/edit'),
        ];
    }
}
