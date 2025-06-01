<?php

namespace App\Filament\Resources\ItopupReplaceResource\Pages;

use App\Filament\Resources\ItopupReplaceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateItopupReplace extends CreateRecord
{
    protected static string $resource = ItopupReplaceResource::class;

    // Add these methods to automatically set the user_id
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id(); // Set the logged-in user's ID
        return $data;
    }

    protected function mutateFormDataBeforeUpdate(array $data): array
    {
        $data['user_id'] = Auth::id(); // Set the logged-in user's ID
        return $data;
    }
}
