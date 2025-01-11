<?php

namespace App\Filament\Owner\Resources;

use App\Filament\Owner\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Nonaktifkan fitur edit
    public static function canEdit($record): bool
    {
        return false;
    }
    // Nonaktifkan fitur edit
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Pilih Tenant
                Forms\Components\Select::make('tenant_id')
                    ->label('Tenant')
                    ->relationship('tenant', 'name') // Relasi ke model User (tenant)
                    ->required(),

                // Pilih Kost
                Forms\Components\Select::make('kost_id')
                    ->label('Kost')
                    ->relationship('kost', 'name') // Relasi ke model Kost
                    ->required(),

                // Rating
                Forms\Components\TextInput::make('rating')
                    ->label('Rating')
                    ->numeric()
                    ->minValue(1) // Nilai minimum rating
                    ->maxValue(5) // Nilai maksimum rating
                    ->step(0.1) // Langkah increment (misal: 4.1, 4.2, dst.)
                    ->required(),

                // Review
                Forms\Components\Textarea::make('review')
                    ->label('Review')
                    ->required()
                    ->maxLength(500) // Batas maksimal karakter
                    ->columnSpan('full'), // Mengisi seluruh kolom

                // Timestamps (opsional, bisa dihilangkan jika tidak diperlukan)
                Forms\Components\DateTimePicker::make('created_at')
                    ->label('Dibuat Pada')
                    ->disabled(), // Nonaktifkan input untuk created_at
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $ownerId = auth()->id();
                // Filter review hanya untuk kost yang dimiliki oleh user dengan role 'owner'
                return Review::query()
                    ->whereHas('kost', function ($query) use ($ownerId) {
                        $query->where('owner_id', $ownerId);
                    });
            })
            ->columns([
                // Kolom Nama Kost
                TextColumn::make('kost.name')
                    ->label('Nama Kost')
                    ->searchable() // Kolom bisa dicari
                    ->sortable(), // Kolom bisa diurutkan

                // Kolom Isi Review
                TextColumn::make('review')
                    ->label('Isi Review')
                    ->limit(100) // Batasi panjang teks yang ditampilkan
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 100 ? $state : null; // Tampilkan tooltip jika teks dipotong
                    })
                    ->wrap() // Teks akan di-wrap jika terlalu panjang
                    ->sortable(),

                // Kolom Rating
                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 1); // Format rating dengan 1 digit desimal
                    })
                    ->sortable(),
            ])

            ->filters([
                //
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
