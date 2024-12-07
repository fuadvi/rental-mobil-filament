<?php

namespace App\Filament\Resources;

use App\Models\Tour;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\CreateRecord;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\TourResource\Pages;
use App\Filament\Resources\TourResource\RelationManagers\CarsRelationManager;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              Section::make("Create a Tour")
              ->schema([
                TextInput::make('title')
                ->label(__('Judul Tour'))
                ->required()
                ->maxLength(255)
                ->validationMessages([
                    'required' => 'field nama tour tidak boleh kosong.',
                ]),

                Select::make('car_list')
                ->label(__('Daftar Mobil'))
                // ->options(function () {
                //     return Car::pluck('title', 'id');
                // })
                ->relationship('cars','title')
                ->multiple()
                ->required()
                ->visible(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                ->validationMessages([
                    'required' => 'field daftar mobil tidak boleh kosong.',
                ]),

            TextInput::make('price')
                ->label(__('Harga Tour'))
                ->required()
                ->numeric()
                ->validationMessages([
                    'required' => 'field harga tour tidak boleh kosong.',
                ]),

            TextInput::make('duration')
                ->label(__('Durasi Tour'))
                ->required()
                ->maxLength(255)
                ->validationMessages([
                    'required' => 'field durasi tour tidak boleh kosong.',
                ]),

                FileUpload::make('image')
                  ->label(__('Gambar Tour'))
                  ->image()
                  ->maxSize(2024) // maksimal 1MB
                  ->directory('tours')
                  ->preserveFilenames()
                  ->columnSpanFull()
                  ->required(fn ($livewire) => $livewire instanceof CreateRecord) // Hanya wajib di create
                  ->validationMessages([
                    'required' => 'Field upload gambar tidak boleh kosong.',
                  ]),



                RichEditor::make('description')
                  ->label(__('Keterangan'))
                  ->required()
                  ->maxLength(500)
                  ->columnSpanFull()
                  ->validationMessages([
                      'required' => 'field keterangan tidak boleh kosong.',
                  ]),


                ]),



              // Group::make()->schema([
              //   Section::make('daftar mobil')->schema([
              //     Select::make('mobil')
              //     ->multiple()
              //     ->relationship('cars','title')
              //   ])
              // ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              TextColumn::make('title')
              ->label(__('Judul Tour'))
              ->sortable()
              ->searchable(),

              TextColumn::make('price')
              ->label(__('Harga Tour'))
              ->sortable()
              ->searchable(),

              TextColumn::make('duration')
              ->label(__('durasi tour'))
              ->sortable()
              ->searchable(),

              TextColumn::make('description')
              ->label(__('Deskripsi'))
              ->searchable()
              ->formatStateUsing(function ($state) {
                  return strip_tags($state); // Menghilangkan tag HTML
              })
              ->limit(50),

              ImageColumn::make('image')
                ->label(__('Gambar'))
                ->getStateUsing(function (Tour $record): string {
//                  return asset("storage/{$record->image}");
                  return $record->image;
                })
//                ->url(fn ($record) => asset("storage/{$record->image}"))
                ->url(fn ($record) => $record->image)
                ->rounded()
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
          CarsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Data Paket Tour');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Data Paket Tour');
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-map'; // untuk Data Paket Tour
    }
}
