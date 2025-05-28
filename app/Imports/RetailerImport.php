<?php

namespace App\Imports;

use App\Models\Retailer;
use App\Models\Rso;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RetailerImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
     * @param array $row
     * @return Retailer
     */
    public function model(array $row): Retailer
    {
        $convertDate = fn($value) =>
        is_numeric($value)
            ? Carbon::createFromDate(1899, 12, 30)->addDays($value)->format('Y-m-d')
            : (!empty($value) ? Carbon::parse($value)->format('Y-m-d') : null);

        return new Retailer([
            'house_id' => Filament::getTenant()->id,
            'rso_id' => Rso::firstWhere('itop_number', $row['rso_number'])->id,
            'code' => $row['retailer_code'],
            'name' => $row['retailer_name'],
            'type' => $row['type'],
            'enabled' => $row['enabled'],
            'sso' => $row['sso'],
            'itop_number' => $row['itop_number'],
            'service_point' => $row['service_point'],
            'category' => $row['category'],
            'owner_name' => $row['owner_name'],
            'owner_number' => $row['owner_number'],
            'division' => $row['division'],
            'district' => $row['district'],
            'thana' => $row['thana'],
            'address' => $row['address'],
            'nid' => $row['nid'],
            'dob' => $convertDate($row['dob']),
            'is_rso_code' => $row['is_rso_code'],
            'is_bp_code' => $row['is_bp_code'],
        ]);
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 500;
    }
}






















//Retailer Code
//Retailer Name
//Type
//Enabled
//SSO
//Rso Number
//Itop Number
//Service Point
//Category
//Owner Name
//Owner Number
//Division
//District
//Thana
//Address
//Nid
//DOB
//Is Rso Code
//Is Bp Code
