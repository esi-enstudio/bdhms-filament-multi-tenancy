<?php

namespace App\Imports;

use App\Models\Bts;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BtsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return Bts
     */
    public function model(array $row): Bts
    {
        $convertDate = fn($value) =>
        is_numeric($value)
            ? Carbon::createFromDate(1899, 12, 30)->addDays($value)->format('Y-m-d')
            : (!empty($value) ? Carbon::parse($value)->format('Y-m-d') : null);

        return new Bts([
            'house_id' => Filament::getTenant()->id,
            'site_id' => $row['site_id'],
            'bts_code' => $row['bts_code'],
            'site_type' => $row['site_type'],
            'thana' => $row['thana'],
            'district' => $row['district'],
            'division' => $row['division'],
            'region' => $row['region'],
            'cluster' => $row['cluster'],
            'bts_address' => $row['bts_address'],
            'urban_rural' => $row['urbanrural'],
            'longitude' => $row['longitude'],
            'latitude' => $row['latitude'],
            'network_mode' => $row['network_mode'],
            'archetype' => $row['archetype'],
            '2g_onair_date' => $convertDate($row['2g_on_air_date']),
            '3g_onair_date' => $convertDate($row['3g_on_air_date']),
            '4g_onair_date' => $convertDate($row['4g_on_air_date']),
            'priority' => $row['priority'],
        ]);
    }
}
