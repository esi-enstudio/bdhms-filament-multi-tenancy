<?php

namespace App\Filament\Resources\BtsResource\Pages;

use App\Filament\Resources\BtsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBts extends ListRecords
{
    protected static string $resource = BtsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
