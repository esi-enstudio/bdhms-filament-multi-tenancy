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
            Actions\CreateAction::make()
                ->icon('heroicon-s-plus')
                ->label('Add New')
                ->successNotificationTitle('New itopup replace request created successfully')
                ->after(function () {
                    $this->dispatch('refreshTabs');
                }),
        ];
    }

    protected function getListeners(): array
    {
        return [
            'refreshTabs' => 'refresh',
        ];
    }

    public function refresh(): void
    {
        // This will force a re-render of the component
        $this->resetPage();
    }

    public function getTabs(): array
    {
        return [
            'Today' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where([['status','!=','canceled'],['status','!=','complete']])->whereDate('created_at', Carbon::today()))
                ->badge(function () {
                    return $this->getModel()::where([['status','!=','canceled'],['status','!=','complete']])->whereDate('created_at', today())->count();
                }),

            'Canceled' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'canceled'))
                ->badge(function () {
                    return $this->getModel()::where('status', 'canceled')->count();
                }),

            'ALL' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query)
                ->badge(function () {
                    return $this->getModel()::count();
                }),
        ];
    }
}
