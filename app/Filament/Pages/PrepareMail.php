<?php

namespace App\Filament\Pages;

use App\Models\ItopupReplace;
use Filament\Pages\Page;

class PrepareMail extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationParentItem = 'Itopup Replaces';

    protected static string $view = 'filament.pages.prepare-mail';

    public static function canAccess(): bool
    {
        return auth()->user()->hasAnyRole(['super_admin','admin']);
    }

    protected function getViewData(): array
    {
        $today = now()->startOfDay();

        $replacements = ItopupReplace::with(['user','house','issueRetailer'])
            ->whereDate('created_at', $today)
            ->where('status', 'pending')
            ->get();

        return [
            'replacements' => $replacements,
        ];
    }
}
