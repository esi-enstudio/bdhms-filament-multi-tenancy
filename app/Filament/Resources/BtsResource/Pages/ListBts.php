<?php

namespace App\Filament\Resources\BtsResource\Pages;

use App\Filament\Resources\BtsResource;
use App\Imports\BtsImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions\Action;
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

            ExcelImportAction::make()
                ->slideOver()
                ->color("primary")
                ->authorize('import_bts')
                ->use(BtsImport::class)
                ->validateUsing([
                    'site_id' => ['required'],
                    'bts_code' => ['required'],
                    'site_type' => ['required'],
                    'thana' => ['required'],
                    'district' => ['required'],
                    'division' => ['required'],
                    'region' => ['required'],
                    'cluster' => ['required'],
                    'bts_address' => ['required'],
                    'urbanrural' => ['required'],
                    'longitude' => ['required'],
                    'latitude' => ['required'],
                    'network_mode' => ['required'],
                    'priority' => ['required'],
                ])
                ->sampleExcel(
                    sampleData: [
                        'DD Code' => 'MYMVAI01',
                        'Site ID' => 'DHK_L0504',
                        'BTS Code' => 'DHK0504',
                        'Site Type' => 'Macro',
                        'Thana' => 'Bajitpur',
                        'District' => 'Kishoreganj',
                        'Division' => 'Dhaka',
                        'Region' => 'Brahmanbaria',
                        'Cluster' => 'East Cluster',
                        'BTS Address' => 'Murshiduddin Hall, Bajitpur Medical College, Bajitpur, Kishoreganj.',
                        'Urban/Rural' => 'Semi-urban',
                        'Longitude' => '90.91705',
                        'Latitude' => '24.20107',
                        'Network Mode' => '2G+4G',
                        'Archetype' => 'BL Core Markets',
                        '2g On Air Date' => '25-12-2005',
                        '3g On Air Date' => '',
                        '4g On Air Date' => '24-06-2019',
                        'Priority' => 'P1',
                    ],
                    fileName: 'bts-sample.xlsx',
//                    exportClass: ,
                    sampleButtonLabel: 'Download Sample',
                    customiseActionUsing: fn(Action $action) => $action->color('danger')
                        ->icon('heroicon-m-clipboard'),
                ),
        ];
    }
}
