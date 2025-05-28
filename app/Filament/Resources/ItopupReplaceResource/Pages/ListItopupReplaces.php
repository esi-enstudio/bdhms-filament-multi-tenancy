<?php

namespace App\Filament\Resources\ItopupReplaceResource\Pages;

use App\Filament\Resources\ItopupReplaceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItopupReplaces extends ListRecords
{
    protected static string $resource = ItopupReplaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-s-plus')->label('Add New'),
        ];
    }
}
