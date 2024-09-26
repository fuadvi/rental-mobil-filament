<?php

namespace App\Filament\Resources\LeaseTypeResource\Pages;

use App\Filament\Resources\LeaseTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaseTypes extends ListRecords
{
    protected static string $resource = LeaseTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
