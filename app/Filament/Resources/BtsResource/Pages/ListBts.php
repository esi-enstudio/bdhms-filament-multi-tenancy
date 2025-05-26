<?php

namespace App\Filament\Resources\BtsResource\Pages;

use App\Filament\Resources\BtsResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListBts extends ListRecords
{
    protected static string $resource = BtsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add New')
                ->icon('heroicon-s-plus'),

            ImportAction::make()
                ->icon('heroicon-s-arrow-down-tray')
                ->fields([
                    ImportField::make('house_id')
                        ->label('DD House')
                        ->mutateBeforeCreate(fn($value) => Filament::getTenant()?->id),

                    ImportField::make('code'),

                    ImportField::make('name'),

                    ImportField::make('description'),

                    ImportField::make('length'),

                    ImportField::make('weekday')
                        ->label('Serving Days (e.g., Sat,Sun,Mon)')
                        ->mutateBeforeCreate(function ($value) {
                            return array_map('trim', explode(',', $value));
                        })

                ], columns:2)
        ];
    }
}
