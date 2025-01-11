<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KostAdvertisementResource\Pages;
use App\Models\AdvertisementDuration;
use App\Models\Kost;
use App\Models\KostAdvertisement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class KostAdvertisementResource extends Resource
{
    protected static ?string $model = KostAdvertisement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Status Iklan')
                        ->schema([
                            Forms\Components\Card::make()
                                ->schema([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\Select::make('status')
                                                ->label('Status Iklan')
                                                ->options([
                                                    'cancelled' => '❌ Cancelled',
                                                    'awaiting_payment' => '💳 Awaiting Payment',
                                                    'active' => '✅ Active',
                                                    'expired' => '⏳ Expired',
                                                ])
                                                ->required()
                                                ->helperText('Pilih status iklan untuk kost ini.'),

                                            Forms\Components\Select::make('advertisement_duration_id')
                                                ->label('Advertisement Duration')
                                                ->native(false)
                                                ->options(function () {
                                                    return AdvertisementDuration::pluck('duration', 'id');
                                                })
                                                ->required()
                                                ->live()
                                                ->afterStateUpdated(function ($state, callable $set) {
                                                    $duration = AdvertisementDuration::find($state);
                                                    if ($duration) {
                                                        $set('price', $duration->price);
                                                    }
                                                })
                                                ->suffix('Hari')
                                                ->disabled(fn ($operation) => $operation === 'edit')
                                                ->helperText('Pilih durasi iklan(Hari).'),

                                            Forms\Components\DatePicker::make('start_date')
                                                ->label('Tanggal Mulai')
                                                ->required()
                                                ->minDate(now())
                                                ->disabled(fn ($operation) => $operation === 'edit')
                                                ->helperText('Tanggal awal iklan untuk kost ini.')
                                                ->suffixIcon('heroicon-o-calendar'),

                                            Forms\Components\DatePicker::make('end_date')
                                                ->label('Tanggal Berakhir')
                                                ->required()
                                                ->minDate(now())
                                                ->rules([
                                                    fn (callable $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                                        $startDate = $get('start_date');
                                                        if ($value <= $startDate) {
                                                            $fail('Tanggal berakhir harus lebih besar dari tanggal mulai.');
                                                        }
                                                    },
                                                ])
                                                ->helperText('Pilih tanggal berakhir iklan untuk kost ini.')
                                                ->suffixIcon('heroicon-o-calendar'),

                                            Forms\Components\Fieldset::make('Pengaturan Premium')
                                                ->schema([
                                                    Forms\Components\Toggle::make('kost.is_premium')
                                                        ->label('Kost Premium')
                                                        ->required()
                                                        ->inline()
                                                        ->afterStateHydrated(function (Forms\Components\Toggle $component, $record) {
                                                            if ($record && $record->kost) {
                                                                $component->state($record->kost->is_premium);
                                                            }
                                                        })
                                                        ->helperText('Status premium kost ini.'),
                                                ]),
                                        ]),
                                ])
                                ->columns(1)
                                ->extraAttributes(['class' => 'bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-md']),
                        ]),


                    Forms\Components\Wizard\Step::make('Detail Bukti Pembayaran')
                        ->schema([
                            Forms\Components\FileUpload::make('payment_proof')
                                ->label('Payment Proof')
                                ->image()
                                ->directory('payment-proofs')
                                ->maxSize(2048)
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->downloadable()
                                ->helperText('Unggah bukti pembayaran (maksimal 2MB, format JPEG/PNG/WebP).'),

                            Forms\Components\Select::make('advertisement_duration_id')
                                ->label('Advertisement Duration')
                                ->native(false)
                                ->options(function () {
                                    return AdvertisementDuration::pluck('duration', 'id');
                                })
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $duration = AdvertisementDuration::find($state);
                                    if ($duration) {
                                        $set('price', $duration->price);
                                    }
                                })
                                ->suffix('Hari')
                                ->disabled(fn ($operation) => $operation === 'edit')
                                ->helperText('Pilih durasi iklan(Hari).'),

                            Forms\Components\TextInput::make('price')
                                ->label('Price')
                                ->disabled()
                                ->dehydrated()
                                ->required()
                                ->helperText('Harga akan diisi otomatis berdasarkan durasi iklan.'),

                            Forms\Components\DatePicker::make('start_date')
                                ->label('Start Date')
                                ->required()
                                ->minDate(now())
                                ->disabled(fn ($operation) => $operation === 'edit')
                                ->helperText('Tanggal anda ingin kost mulai diiklan atau dipromosikan.'),

                        ]),

                    Forms\Components\Wizard\Step::make('Kost Information')
                        ->schema([
                            Forms\Components\Select::make('kost_id')
                                ->label('Pilih Kost')
                                ->options(function () {
                                    return Kost::where('owner_id', auth()->id())
                                        ->pluck('name', 'id');
                                })
                                ->required()
                                ->disabled(fn ($operation) => $operation === 'edit')
                                ->helperText('Pilih kost yang ingin dipromosikan.')
                                ->native(false),

                            Forms\Components\TextInput::make('promo_code')
                                ->label('Promo Code')
                                ->maxLength(255)
                                ->nullable()
                                ->disabled(fn ($operation) => $operation === 'edit')
                                ->helperText('Masukkan kode promo jika ada.'),

                            Forms\Components\Select::make('promo_type')
                                ->label('Promo Type')
                                ->native(false)
                                ->options([
                                    'percentage' => 'Percentage',
                                    'fixed' => 'Fixed Amount',
                                ])
                                ->nullable()
                                ->live()
                                ->afterStateUpdated(fn ($state, callable $set) =>
                                $state === null ? $set('promo_value', null) : null
                                )
                                ->disabled(fn ($operation) => $operation === 'edit')
                                ->helperText('Pilih jenis promo yang ingin digunakan.'),

                            Forms\Components\TextInput::make('promo_value')
                                ->label('Promo Value')
                                ->numeric()
                                ->nullable()
                                ->visible(fn (callable $get) => $get('promo_type') !== null)
                                ->rules([
                                    fn (callable $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                        if ($get('promo_type') === 'percentage' && $value > 100) {
                                            $fail('Persentase tidak boleh lebih dari 100.');
                                        }
                                        if ($value < 0) {
                                            $fail('Promo value tidak boleh negatif.');
                                        }
                                    },
                                ])
                                ->disabled(fn ($operation) => $operation === 'edit')
                                ->helperText('Masukkan nilai promo.'),

                            Forms\Components\FileUpload::make('promotional_photo')
                                ->label('Foto Promosi(Jika Perlu')
                                ->image()
                                ->directory('promotional-photos')
                                ->maxSize(5120)
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->downloadable()
                                ->nullable()
                                ->helperText('Unggah foto promosi (maksimal 5MB, format JPEG/PNG/WebP).'),
                        ]),

                ])
                    ->skippable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kost.name')
                    ->label('Nama Kost'),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date('d M Y')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Berakhir')
                    ->date('d M Y')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga Premium')
                    ->prefix('Rp')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.'))
                    ->alignment('center'),

                Tables\Columns\ImageColumn::make('payment_proof')
                    ->label('Bukti Pembayaran')
                    ->circular()
                    ->alignment('center'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'danger' => 'cancelled',
                        'info' => 'awaiting_payment',
                        'success' => 'active',
                        'secondary' => 'expired',
                    ])
                    ->tooltip(fn ($state) => "Status: " . ucfirst($state))
                    ->alignment('center'),
            ])
            ->filters([
                // Filter sesuai status
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'cancelled' => 'Dibatalkan',
                        'awaiting_payment' => 'Menunggu Pembayaran',
                        'active' => 'Aktif',
                        'expired' => 'Berakhir',
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKostAdvertisements::route('/'),
            'create' => Pages\CreateKostAdvertisement::route('/create'),
            'edit' => Pages\EditKostAdvertisement::route('/{record}/edit'),
        ];
    }
}
