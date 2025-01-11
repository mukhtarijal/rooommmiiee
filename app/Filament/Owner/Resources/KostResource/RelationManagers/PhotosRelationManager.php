<?php

namespace App\Filament\Owner\Resources\KostResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Tipe Foto')
                    ->options([
                        'kost' => 'Foto Bangunan Kost',
                        'room' => 'Foto Kamar',
                        'bathroom' => 'Foto Kamar Mandi',
                        'other' => 'Foto Lainnya',
                    ])
                    ->required()
                    ->native(false),

                Forms\Components\FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->directory('kost-photos')
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('1024')
                    ->imageResizeTargetHeight('768')
                    ->required()
                    ->multiple()
                    ->minFiles(2)
                    ->maxFiles(5)
                    ->maxSize(1024 * 5)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                    ->helperText('Minimal 2 file dan Maksimal 5 file, masing-masing maksimal 5MB. Hanya file JPEG, PNG, dan WebP yang diizinkan.')
                    ->reorderable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular()
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'kost' => 'Bangunan Kost',
                        'room' => 'Kamar',
                        'bathroom' => 'Kamar Mandi',
                        'other' => 'Lainnya',
                    })
                    ->alignment('center'),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
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
