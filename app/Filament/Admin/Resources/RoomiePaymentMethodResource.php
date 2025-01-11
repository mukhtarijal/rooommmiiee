<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RoomiePaymentMethodResource\Pages;
use App\Models\RoomiePaymentMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RoomiePaymentMethodResource extends Resource
{
    protected static ?string $model = RoomiePaymentMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('payment_method_id')
                    ->relationship('paymentMethod', 'name')
                    ->required()
                    ->preload()
                    ->placeholder('Pilih metode pembayaran')
                    ->helperText('Pilih metode pembayaran yang tersedia.'),

                Forms\Components\TextInput::make('account_number')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan nomor rekening')
                    ->helperText('Contoh: 1234567890'),

                Forms\Components\TextInput::make('account_name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan nama pemilik rekening')
                    ->helperText('Nama harus sesuai dengan nama di rekening.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paymentMethod.name')
                    ->label('Metode Pembayaran'),

                Tables\Columns\TextColumn::make('account_number')
                    ->label('Nomor Rekening')
                    ->limit(20)
                    ->alignment('center')
                    ->copyable(),

                Tables\Columns\TextColumn::make('account_name')
                    ->label('Nama Pemilik Rekening')
                    ->alignment('center')
                    ->limit(30),
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
            'index' => Pages\ListRoomiePaymentMethods::route('/'),
            'create' => Pages\CreateRoomiePaymentMethod::route('/create'),
            'edit' => Pages\EditRoomiePaymentMethod::route('/{record}/edit'),
        ];
    }
}
