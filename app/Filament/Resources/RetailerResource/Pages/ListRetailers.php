<?php

namespace App\Filament\Resources\RetailerResource\Pages;

use App\Filament\Resources\RetailerResource;
use App\Imports\RetailerImport;
use App\Models\Retailer;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListRetailers extends ListRecords
{
    protected static string $resource = RetailerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-s-plus')->label('Add New'),

            ExcelImportAction::make()
                ->slideOver()
                ->color("primary")
                ->use(RetailerImport::class)
                ->authorize('import_btn_retailer')
                ->validateUsing([
                    'rso_number' => ['required'],
                    'retailer_code' => ['required'],
                    'retailer_name' => ['required'],
                    'type' => ['required'],
                    'enabled' => ['required'],
                    'sso' => ['required'],
                    'itop_number' => ['required'],
                ])
                ->sampleExcel(
                    sampleData: [
                        'DD Code' => 'MYMVAI01',
                        'Retailer Code' => 'R028785',
                        'Retailer Name' => 'Manik Telecom',
                        'Type' => 'TELECOM',
                        'Enabled' => 'Y',
                        'SSO' => 'Y',
                        'Rso Number' => '01915270103',
                        'Itop Number' => '01915388215',
                        'Service Point' => 'RBSP',
                        'Category' => '',
                        'Owner Name' => 'manik lal',
                        'Owner Number' => '01915388215',
                        'Division' => 'Dhaka',
                        'District' => 'Kishoreganj',
                        'Thana' => 'Bajitpur',
                        'Address' => 'Hazi Elias Road, Bajitpur, Kishoregonj',
                        'Nid' => '6412366307',
                        'DOB' => '',
                        'Is Rso Code' => '',
                        'Is Bp Code' => '',
                    ],
                    fileName: 'retailer-sample.xlsx',
//                    exportClass: ,
                    sampleButtonLabel: 'Download Sample',
                    customiseActionUsing: fn(Action $action) => $action->color('danger')
                        ->icon('heroicon-m-clipboard'),
                ),
        ];
    }
}
