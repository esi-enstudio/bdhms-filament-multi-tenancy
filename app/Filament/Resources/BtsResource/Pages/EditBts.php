<?php

namespace App\Filament\Resources\BtsResource\Pages;

use App\Filament\Resources\BtsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBts extends EditRecord
{
    protected static string $resource = BtsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
