<?php

namespace App\Filament\Resources\ItopupReplaceResource\Pages;

use App\Filament\Resources\ItopupReplaceResource;
use App\Models\ItopupReplace;
use Exception;
use Filament\Resources\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class History extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = ItopupReplaceResource::class;

    protected static string $view = 'filament.resources.itopup-replace-resource.pages.itopup-replacement-history';

    public $record;

    public function mount($record): void
    {
        $this->record = ItopupReplace::findOrFail($record);
    }

    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return $table->query(ItopupReplace::query()->where('retailer_id', $this->record->retailer_id))
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('retailer.itop_number')
                    ->searchable(),
                TextColumn::make('sim_serial')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('balance')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('reason')
                    ->formatStateUsing(fn($state) => Str::title($state))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => Str::title($state))
                    ->sortable()
                    ->badge()
                    ->color(function ($state){
                        if ($state == "pending") {
                            return 'secondary';
                        }elseif ($state == "canceled")
                        {
                            return 'danger';
                        }elseif ($state == "processing")
                        {
                            return 'warning';
                        }elseif ($state == "complete")
                        {
                            return 'success';
                        }

                        return false;
                    }),
                TextColumn::make('remarks')
                    ->formatStateUsing(fn($state) => Str::title($state))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultPaginationPageOption(5)
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'canceled' => 'Canceled',
                        'complete' => 'Complete',
                    ])
                    ->query(function ($query, array $data) {
                        if (!empty($data['value'])) {
                            $query->where('status', $data['value']);
                        }
                    }),

                DateRangeFilter::make('created_at')->label('Date')->timezone('Asia/Dhaka'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
