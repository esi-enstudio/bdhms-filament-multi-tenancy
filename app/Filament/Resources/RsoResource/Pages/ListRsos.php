<?php

namespace App\Filament\Resources\RsoResource\Pages;

use App\Filament\Resources\RsoResource;
use App\Imports\RsoImport;
use App\Models\User;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListRsos extends ListRecords
{
    protected static string $resource = RsoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-s-plus'),

            ExcelImportAction::make()
                ->slideOver()
                ->color("primary")
                ->use(RsoImport::class)
                ->validateUsing([
                    'user_number' => ['required'],
                    'supervisor_number' => ['required'],
                    'rso_code' => ['required'],
                    'itop_number' => ['required'],
                    'pool_number' => ['required'],
                ])
                ->sampleExcel(
                    sampleData: [
                        'DD Code'               => 'MYMVAI01',
                        'User Number'           => '01711000001',
                        'Supervisor Number'     => '01923909896',
                        'OSRM Code'             => 'IMS0028073',
                        'Employee Code'         => 'MOS546',
                        'Rso Code'              => 'RS042015',
                        'Itop Number'           => '01409944001',
                        'Pool Number'           => '01935593311',
                        'Personal Number'       => '01611000001',
                        'Name as Bank Account'  => 'Safiqul Islam',
                        'Religion'              => 'Islam',
                        'Bank Name'             => 'DBBL Core',
                        'Bank Account Number'   => '173XXXXXXX121',
                        'Brunch Name'           => 'BHAIRAB BRANCH',
                        'Routing Number'        => '090480193',
                        'Education'             => 'SSC',
                        'Blood Group'           => 'O+',
                        'Gender'                => 'male',
                        'Present Address'       => 'Bhairabpur, Bhairab, Kishoreganj.',
                        'Permanent Address'     => 'Bhairabpur, Bhairab, Kishoreganj.',
                        'Father Name'           => 'Mamun Mia',
                        'Mother Name'           => 'Momena Khatun',
                        'Market Type'           => 'HLPV',
                        'Salary'                => '8500',
                        'Category'              => 'Existing',
                        'Agency Name'           => 'IMS',
                        'DOB'                   => '10-10-2001',
                        'NID'                   => '7804723877',
                        'Division'              => 'Dhaka',
                        'District'              => 'Kishoreganj',
                        'Thana'                 => 'Bhairab',
                        'SR_NO'                 => 'SR-23',
                        'Joining Date'          => '01-08-2024',
                    ],
                    fileName: 'rso-sample.xlsx',
//                    exportClass: ,
                    sampleButtonLabel: 'Download Sample',
                    customiseActionUsing: fn(Action $action) => $action->color('danger')
                        ->icon('heroicon-m-clipboard'),
                ),
        ];
    }
}
