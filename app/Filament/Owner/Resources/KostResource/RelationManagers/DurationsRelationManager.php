<?php

namespace App\Filament\Owner\Resources\KostResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DurationsRelationManager extends RelationManager
{
    protected static string $relationship = 'durations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Tipe Durasi')
                    ->options([
                        'daily' => 'Perhari',
                        'weekly' => 'Perminggu',
                        'monthly' => 'Perbulan',
                        '3_monthly' => 'Per Tiga Bulan',
                        '6_monthly' => 'Per Enam Bulan',
                        'yearly' => 'Pertahun',
                    ])
                    ->required()
                    ->native(false),

                Forms\Components\TextInput::make('price')
                    ->label('Harga Sewa')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->prefix('Rp')
                    ->placeholder('Masukkan harga sewa'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'daily' => 'Perhari',
                        'weekly' => 'Perminggu',
                        'monthly' => 'Perbulan',
                        '3_monthly' => 'Per Tiga Bulan',
                        '6_monthly' => 'Per Enam Bulan',
                        'yearly' => 'Pertahun',
                    }),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga Sewa')
                    ->formatStateUsing(fn (string $state): string => 'Rp ' . number_format($state, 2, ',', '.'))
                    ->alignment('center'),
            ])

            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
