<?php

namespace App\Filament\Resources\LeaseTypeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;

class CarsRelationManager extends RelationManager
{
    protected static string $relationship = 'cars';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
              TextColumn::make('title')
              ->label(__('Nama Mobil'))
              ->sortable()
              ->searchable(),


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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     // Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
