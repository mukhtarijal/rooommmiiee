<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\HelpCenterResource\Pages;
use App\Models\HelpCenter;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HelpCenterResource extends Resource
{
    protected static ?string $model = HelpCenter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->columnSpan(2)
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->columnSpan(2)
                    ->label('Isi')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Isi')
                    ->limit(75) // Batasi tampilan teks hingga 50 karakter
                    ->tooltip(function (TextColumn $column): ?string {
                        // Tampilkan tooltip dengan teks lengkap saat di-hover
                        $state = $column->getState();
                        if (strlen($state) > 75) {
                            return $state;
                        }
                        return null;
                    })
                    ->alignment('center'),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHelpCenters::route('/'),
            'create' => Pages\CreateHelpCenter::route('/create'),
            'edit' => Pages\EditHelpCenter::route('/{record}/edit'),
        ];
    }
}
