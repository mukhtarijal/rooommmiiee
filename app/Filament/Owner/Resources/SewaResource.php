<?php

namespace App\Filament\Owner\Resources;

use App\Filament\Owner\Resources\SewaResource\Pages;
use App\Models\Kost;
use App\Models\Sewa;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SewaResource extends Resource
{
    protected static ?string $model = Sewa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Nonaktifkan fitur create
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Langkah 1: Informasi Sewa')
                        ->schema([
                            Select::make('status')
                                ->options([
                                    'approved' => '✅ Approved',
                                    'cancelled' => '❌ Cancelled',
                                    'payment_verified' => '💰 Payment Verified',
                                    'active' => '🟢 Active',
                                    'expired' => '🔴 Expired',
                                ])
                                ->label('Status')
                                ->native(false)
                                ->required()
                                ->columnSpanFull(),
                            Select::make('duration')
                                ->label('Durasi (bulan)')
                                ->options(function (callable $get) {
                                    $kostId = $get('kost_id');

                                    if ($kostId) {
                                        $kost = Kost::find($kostId);
                                        return $kost->durations()->pluck('type', 'type')->toArray();
                                    }
                                    return [];
                                })
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    if ($state) {
                                        $kostId = $get('kost_id');
                                        if ($kostId) {
                                            $kost = Kost::find($kostId);
                                            $duration = $kost->durations()->where('type', $state)->first();
                                            if ($duration) {
                                                $set('price', $duration->price);
                                            }
                                        }
                                    }
                                })
                                ->disabled(fn ($operation) => $operation === 'edit'),
                            TextInput::make('price')
                                ->label('Harga')
                                ->numeric()
                                ->required()
                                ->disabled(fn ($operation) => $operation === 'edit'),
                            DatePicker::make('start_date')
                                ->label('Tanggal Mulai')
                                ->required()
                                ->disabled(fn ($operation) => $operation === 'edit'),
                            DatePicker::make('end_date')
                                ->label('Tanggal Berakhir')
                                ->required()
                                ->rules([
                                    'after_or_equal:start_date',
                                ]),
                            FileUpload::make('payment_proof')
                                ->label('Bukti Pembayaran')
                                ->directory('sewa-payment-proof')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf'])
                                ->maxSize(2048)
                                ->enableDownload()
                                ->enableOpen(),
                            FileUpload::make('payment_forward')
                                ->label('Bukti Forward Pembayaran Owner')
                                ->directory('payment-forward')
                                ->required()
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf'])
                                ->maxSize(2048)
                                ->enableDownload()
                                ->enableOpen(),
                        ]),
                    Step::make('Langkah 2: Informasi Tambahan')
                        ->schema([
                            Select::make('tenant_id')
                                ->relationship('tenant', 'name')
                                ->label('Penyewa')
                                ->required()
                                ->disabled(fn ($operation) => $operation === 'edit'),
                            Select::make('kost_id')
                                ->relationship('kost', 'name')
                                ->label('Kost')
                                ->required()
                                ->disabled(fn ($operation) => $operation === 'edit'),
                            TextInput::make('promo_code')
                                ->label('Kode Promo')
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
            ->query(function () {
                return Sewa::query()
                    ->whereHas('kost', function ($query) {
                        $query->where('owner_id', auth()->id());
                    });
            })
            ->columns([
                TextColumn::make('tenant.name')
                    ->label('Nama Tenant')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kost.name')
                    ->label('Nama Kost')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date('d-m-Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Tanggal Berakhir')
                    ->date('d-m-Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'pending' => '⏳ Pending',
                            'approved' => '✅ Approved',
                            'cancelled' => '❌ Cancelled',
                            'payment_verified' => '💰 Payment Verified',
                            'active' => '🟢 Active',
                            'expired' => '🔴 Expired',
                            default => $state,
                        };
                    })
                    ->sortable(),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => '⏳ Pending',
                        'approved' => '✅ Approved',
                        'cancelled' => '❌ Cancelled',
                        'payment_verified' => '💰 Payment Verified',
                        'active' => '🟢 Active',
                        'expired' => '🔴 Expired',
                    ]),
            ])
            ->actions([
                // Action untuk mengedit
                Tables\Actions\EditAction::make()
                    ->hidden(fn ($record) => $record->owner_id !== auth()->id()), // Sembunyikan jika bukan milik user

                // Action untuk menghapus
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn ($record) => $record->owner_id !== auth()->id()), // Sembunyikan jika bukan milik user
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
            'index' => Pages\ListSewas::route('/'),
            'create' => Pages\CreateSewa::route('/create'),
            'edit' => Pages\EditSewa::route('/{record}/edit'),
        ];
    }
}
