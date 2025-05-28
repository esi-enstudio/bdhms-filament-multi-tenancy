<?php

namespace App\Filament\Resources\ItopupReplaceResource\Pages;

use App\Filament\Resources\ItopupReplaceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItopupReplace extends EditRecord
{
    protected static string $resource = ItopupReplaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
