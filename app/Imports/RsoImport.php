<?php

namespace App\Imports;

use App\Models\Rso;
use App\Models\User;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RsoImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return Rso
     */
    public function model(array $row): Rso
    {
        $convertDate = fn($value) =>
        is_numeric($value)
            ? Carbon::createFromDate(1899, 12, 30)->addDays($value)->format('Y-m-d')
            : (!empty($value) ? Carbon::parse($value)->format('Y-m-d') : null);

        return new Rso([
            'house_id'          => Filament::getTenant()->id,
            'user_id'               => User::firstWhere('phone_number', $row['user_number'])->id,
            'supervisor_id'         => User::firstWhere('phone_number', $row['supervisor_number'])->id,
            'osrm_code'             => $row['osrm_code'],
            'employee_code'         => $row['employee_code'],
            'rso_code'              => $row['rso_code'],
            'itop_number'           => $row['itop_number'],
            'pool_number'           => $row['pool_number'],
            'personal_number'       => $row['personal_number'],
            'name_as_bank_account'  => $row['name_as_bank_account'],
            'religion'              => $row['religion'],
            'bank_name'             => $row['bank_name'],
            'bank_account_number'   => $row['bank_account_number'],
            'brunch_name'           => $row['brunch_name'],
            'routing_number'        => $row['routing_number'],
            'education'             => $row['education'],
            'blood_group'           => $row['blood_group'],
            'gender'                => $row['gender'],
            'present_address'       => $row['present_address'],
            'permanent_address'     => $row['permanent_address'],
            'father_name'           => $row['father_name'],
            'mother_name'           => $row['mother_name'],
            'market_type'           => $row['market_type'],
            'salary'                => $row['salary'],
            'category'              => $row['category'],
            'agency_name'           => $row['agency_name'],
            'dob'                   => $convertDate($row['dob']),
            'nid'                   => $row['nid'],
            'division'              => $row['division'],
            'district'              => $row['district'],
            'thana'                 => $row['thana'],
            'sr_no'                 => $row['sr_no'],
            'joining_date'          => $convertDate($row['joining_date']),
        ]);
    }
}
