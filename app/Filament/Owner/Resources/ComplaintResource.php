<?php

namespace App\Filament\Owner\Resources;

use App\Filament\Owner\Resources\ComplaintResource\Pages;
use App\Models\Complaint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Nonaktifkan fitur edit
    public static function canEdit($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->disabled()
                    ->dehydrated()
                    ->required(),

                Forms\Components\Select::make('type')
                    ->options([
                        'complaint' => 'Keluhan',
                        'suggestion' => 'Saran',
                        'request' => 'Permintaan',
                    ])
                    ->native(false)
                    ->required()
                    ->placeholder('Pilih tipe aduan')
                    ->helperText('Pilih jenis aduan yang ingin Anda kirimkan.')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('message')
                    ->required()
                    ->placeholder('Tulis pesan aduan Anda di sini')
                    ->helperText('Jelaskan aduan Anda secara detail.')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('supporting_photo')
                    ->image()
                    ->maxSize(1024)
                    ->directory('complaints')
                    ->helperText('Unggah foto pendukung (maksimal 1MB).')
                    ->columnSpanFull(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->query(fn () => Complaint::query()->where('user_id', auth()->id()))
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe Aduan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'complaint' => 'danger',
                        'suggestion' => 'warning',
                        'request' => 'success',
                    }),

                Tables\Columns\TextColumn::make('message')
                    ->label('Pesan Aduan')
                    ->limit(50)
                    ->alignment('center')
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        // Tampilkan tooltip dengan teks lengkap saat di-hover
                        $state = $column->getState();
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    }),

                Tables\Columns\ImageColumn::make('supporting_photo')
                    ->label('Foto Pendukung')
                    ->circular()
                    ->alignment('center'),
            ])
            ->filters([
                // Filter berdasarkan tipe aduan
            ])
            ->actions([

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComplaints::route('/'),
            'create' => Pages\CreateComplaint::route('/create'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}
