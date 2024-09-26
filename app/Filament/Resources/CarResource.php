<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Models\Car;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Sumber daya untuk mengelola mobil.
 */
class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('Nama Mobil'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->validationMessages([
                        'required' => 'field nama mobil tidak boleh kosong.',
                    ]),

                TextInput::make('price')
                    ->label(__('Harga Sewa'))
                    ->required()
                    ->numeric()
                    ->validationMessages([
                        'required' => 'field harga sewa tidak boleh kosong.',
                    ]),

                TextInput::make('duration')
                    ->label(__('Durasi Sewa'))
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'field durasi sewa tidak boleh kosong.',
                    ]),

                RichEditor::make('description')
                    ->label(__('Keterangan'))
                    ->required()
                    ->maxLength(500)
                    ->columnSpanFull()
                    ->validationMessages([
                        'required' => 'field keterangan tidak boleh kosong.',
                    ]),

                TextInput::make('passenger')
                    ->label(__('Jumlah Orang'))
                    ->required()
                    ->integer()
                    ->validationMessages([
                        'required' => 'field Jumlah Orang tidak boleh kosong.',
                    ]),

                TextInput::make('luggage')
                    ->label(__('Muatan Bagasi'))
                    ->required()
                    ->integer()
                    ->validationMessages([
                        'required' => 'field Muatan Bagasi tidak boleh kosong.',
                    ]),

                Select::make('car_type')
                    ->label(__('Tipe Mobil'))
                    ->options([
                        'sedan' => 'Sedan',
                        'suv' => 'SUV',
                        'minivan' => 'Minivan',
                    ])->validationMessages([
                    'required' => 'field tipe mobil tidak boleh kosong.',
                ]),

                Select::make('isDriver')
                    ->label(__('Supir'))
                    ->options([
                        '0' => 'Tidak Termasuk Supir',
                        '1' => 'Sudah Termasuk Supir',
                    ])
                    ->validationMessages([
                        'required' => 'field supir tidak boleh kosong.',
                    ]),

                FileUpload::make('image')
                    ->label(__('Gambar Mobil'))
                    ->required()
                    ->image()
                    ->maxSize(2024) // maksimal 1MB
                    ->columnSpanFull()
                    ->validationMessages([
                        'required' => 'field upload gambar tidak boleh kosong.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('Nama Mobil'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->label(__('Deskripsi'))
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        return strip_tags($state); // Menghilangkan tag HTML
                    })
                    ->limit(50),

                TextColumn::make('price')
                    ->label(__('Harga Sewa'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('passenger')
                    ->label(__('Jumlah Orang'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('luggage')
                    ->label(__('Muatan Bagasi'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('car_type')
                    ->label(__('Tipe Mobil'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('isDriver')
                    ->label(__('Supir'))
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return $state ? 'Sudah Termasuk Supir' : 'Tidak Termasuk Supir';
                    }),

                ImageColumn::make('image')
                    ->label(__('Gambar'))
                    ->getStateUsing(function (Car $record): string {
                        return asset("storage/{$record->image}");
                    })
                    ->url(fn ($record) => asset("storage/{$record->image}"))
                    ->rounded()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Data Mobil');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Data Mobil');
    }

    public static function getNavigationIcon(): string
  {
      return 'heroicon-o-truck'; // untuk Data Mobil
      // return 'heroicon-o-clipboard-document-list'; // untuk Jenis Sewa
      // return 'heroicon-o-map'; // untuk Data Paket Tour
  }
}
