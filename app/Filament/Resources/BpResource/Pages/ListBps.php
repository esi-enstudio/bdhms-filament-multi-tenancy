<?php

namespace App\Filament\Resources\BpResource\Pages;

use App\Filament\Resources\BpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBps extends ListRecords
{
    protected static string $resource = BpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add New'),
        ];
    }
}
