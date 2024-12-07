<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Banner;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BannerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BannerResource\RelationManagers;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->label(__('Gambar Banner'))
                    ->required()
                    ->image()
//                    ->maxSize(2048) // maksimal 1MB
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
              ImageColumn::make('image')
              ->label(__('Gambar'))
              ->getStateUsing(function (Banner $record): string {
//                  return asset("storage/{$record->image}");
                  return $record->image;
              })
//              ->url(fn ($record) => asset("storage/{$record->image}"))
              ->url(fn ($record) => $record->image)
              ->rounded()
              ->size(250, 250)
              ->alignCenter(),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Data Banner');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Data Banner');
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-photo'; // untuk Data banner
    }
}
