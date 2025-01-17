<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\LeaseType;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LeaseTypeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LeaseTypeResource\RelationManagers;
use App\Filament\Resources\LeaseTypeResource\RelationManagers\CarsRelationManager;
use Joshembling\ImageOptimizer\Components\SpatieMediaLibraryFileUpload;

class LeaseTypeResource extends Resource
{
    protected static ?string $model = LeaseType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 TextInput::make('title')
                    ->label(__('Judul Jenis Sewa'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->validationMessages([
                        'required' => 'field judul jenis sewa tidak boleh kosong.',
                    ]),

                    RichEditor::make('description')
                    ->label(__('Keterangan'))
                    ->required()
                    // ->maxLength(500)
                    ->columnSpanFull()
                    ->validationMessages([
                        'required' => 'field keterangan tidak boleh kosong.',
                    ]),


              SpatieMediaLibraryFileUpload::make('image')
                ->label(__('Gambar Jenis Sewa'))
                ->collection('default')
                ->image()
                ->disk('public')
                ->visibility('public')
                ->optimize('webp')
                ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              TextColumn::make('title')
              ->label(__('Judul Jenis Sewa'))
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
              ->getStateUsing(function (LeaseType $record): string {
                  return $record->getFirstMedia('default')->getUrl();
              })
              ->url(fn ($record) => $record->getFirstMedia()->getUrl())
              ->rounded(),
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
            'index' => Pages\ListLeaseTypes::route('/'),
            'create' => Pages\CreateLeaseType::route('/create'),
            'edit' => Pages\EditLeaseType::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Jenis Sewa');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Jenis Sewa');
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-clipboard-document-list'; // untuk Jenis Sewa
    }

}
