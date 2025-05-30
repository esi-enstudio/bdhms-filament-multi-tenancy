<?php

namespace App\Filament\Resources\ItopupReplaceResource\Pages;

use App\Filament\Resources\ItopupReplaceResource;
use Filament\Resources\Pages\Page;

class Data extends Page
{
    protected static string $resource = ItopupReplaceResource::class;

    protected static string $view = 'filament.resources.itopup-replace-resource.pages.data';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'ITopup Data';
    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return auth()->user()->can('view_itopup_data');
    }
}
