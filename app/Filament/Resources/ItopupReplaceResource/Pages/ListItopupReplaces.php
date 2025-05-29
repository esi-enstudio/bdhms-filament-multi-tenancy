<?php

namespace App\Filament\Resources\ItopupReplaceResource\Pages;

use App\Filament\Resources\ItopupReplaceResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListItopupReplaces extends ListRecords
{
    protected static string $resource = ItopupReplaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-s-plus')->label('Add New'),
        ];
    }

    public function getTabs(): array
    {
        $today = Carbon::today();
        $itopupReplace = $this->getModel();
        $todayReplaceCount = $itopupReplace::whereDate('created_at', $today)->count();
        $canceledReplaceCount = $itopupReplace::where('status', 'canceled')->count();
        $allReplaceCount = $itopupReplace::count();

        return [
            'Today' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereDate('created_at', $today))
                ->badge($todayReplaceCount),

            'Canceled' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'canceled'))
                ->badge($canceledReplaceCount),

            'ALL' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query)
                ->badge($allReplaceCount),
        ];
    }
}
