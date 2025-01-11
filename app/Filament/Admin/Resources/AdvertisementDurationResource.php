<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AdvertisementDurationResource\Pages;
use App\Models\AdvertisementDuration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AdvertisementDurationResource extends Resource
{
    protected static ?string $model = AdvertisementDuration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('duration')
                    ->label('Durasi (hari)')
                    ->required()
                    ->numeric()
                    ->placeholder('Masukkan Durasi'),

                Forms\Components\TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->required()
                    ->prefix('Rp')
                    ->placeholder('Enter price'),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('duration')
                    ->label('Durasi')
                    ->suffix(' hari'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->alignment('center')
                    ->formatStateUsing(fn ($state) => 'Rp' . number_format($state, 0, ',', '.')),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdvertisementDurations::route('/'),
            'create' => Pages\CreateAdvertisementDuration::route('/create'),
            'edit' => Pages\EditAdvertisementDuration::route('/{record}/edit'),
        ];
    }
}
