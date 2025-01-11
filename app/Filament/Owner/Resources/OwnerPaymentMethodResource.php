<?php

namespace App\Filament\Owner\Resources;

use App\Filament\Owner\Resources\OwnerPaymentMethodResource\Pages;
use App\Models\OwnerPaymentMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OwnerPaymentMethodResource extends Resource
{
    protected static ?string $model = OwnerPaymentMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('owner_id')
                    ->default(auth()->id())
                    ->disabled()
                    ->dehydrated()
                    ->required(),

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
            ->query(fn () => OwnerPaymentMethod::query()->where('owner_id', auth()->id()))
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
                // Filter berdasarkan metode pembayaran

            ])
            ->actions([
                // Action untuk mengedit
                Tables\Actions\EditAction::make()
                    ->hidden(fn ($record) => $record->owner_id !== auth()->id()),

                // Action untuk menghapus
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn ($record) => $record->owner_id !== auth()->id()),
            ])
            ->bulkActions([
                // Action untuk menghapus beberapa data sekaligus
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOwnerPaymentMethods::route('/'),
            'create' => Pages\CreateOwnerPaymentMethod::route('/create'),
            'edit' => Pages\EditOwnerPaymentMethod::route('/{record}/edit'),
        ];
    }
}
