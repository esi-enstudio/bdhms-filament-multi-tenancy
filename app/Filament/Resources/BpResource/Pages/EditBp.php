<?php

namespace App\Filament\Resources\BpResource\Pages;

use App\Filament\Resources\BpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBp extends EditRecord
{
    protected static string $resource = BpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
