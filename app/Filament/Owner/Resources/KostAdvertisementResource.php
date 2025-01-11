<?php

namespace App\Filament\Owner\Resources;

use App\Filament\Owner\Resources\KostAdvertisementResource\Pages;
use App\Models\AdvertisementDuration;
use App\Models\Kost;
use App\Models\KostAdvertisement;
use App\Models\RoomiePaymentMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
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
                    Forms\Components\Wizard\Step::make('Basic Information')
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
                                ->label('Harga Untuk Promo')
                                ->numeric()
                                ->nullable()
                                ->visible(fn (callable $get) => $get('promo_type') !== null)
                                ->rules([
                                    fn (callable $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                        if ($get('promo_type') === 'percentage' && $value > 100) {
                                            $fail('Persentase tidak boleh lebih dari 100.');
                                        }
                                        if ($value < 0) {
                                            $fail('Harga promo tidak boleh negatif.');
                                        }
                                    },
                                ])
                                ->disabled(fn ($operation) => $operation === 'edit')
                                ->helperText('Masukkan nilai promo.'),

                            Forms\Components\FileUpload::make('promotional_photo')
                                ->label('Foto Promosi(jika ada)')
                                ->image()
                                ->directory('promotional-photos')
                                ->maxSize(5120 )
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->downloadable()
                                ->nullable()
                                ->helperText('Unggah foto promosi (maksimal 5MB, format JPEG/PNG/WebP).'),
                        ]),

                    Forms\Components\Wizard\Step::make('Duration & Price')
                        ->schema([
                            Forms\Components\Select::make('advertisement_duration_id')
                                ->label('Duraasi Iklan yang Anda Inginkan')
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
                                ->helperText('Pilih tanggal anda ingin kost mulai diiklan atau dipromosikan.'),
                        ]),

                    Forms\Components\Wizard\Step::make('Payment Information')
                        ->schema([
                            Forms\Components\View::make('filament.forms.components.payment-instructions')
                                ->viewData([
                                    'price' => fn ($get) => $get('price'),
                                    'paymentMethods' => RoomiePaymentMethod::with('paymentMethod')->get(),
                                ])
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Wizard\Step::make('Bukti Pembayaran')
                        ->schema([
                            Forms\Components\FileUpload::make('payment_proof')
                                ->label('Payment Proof')
                                ->image()
                                ->directory('payment-proofs')
                                ->maxSize(2048)
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->downloadable()
                                ->helperText('Unggah bukti pembayaran (maksimal 2MB, format JPEG/PNG/WebP).'),
                        ]),
                ])
                    ->skippable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return KostAdvertisement::query()
                    ->whereHas('kost', function ($query) {
                        $query->where('owner_id', auth()->id());
                    });
            })
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
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(fn ($record) => in_array($record->status, ['active', 'expired'])), // Sembunyikan jika status aktif atau kedaluwarsa
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
