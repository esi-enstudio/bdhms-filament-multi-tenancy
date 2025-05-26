<?php

namespace App\Filament\Resources\RsoResource\Pages;

use App\Filament\Resources\RsoResource;
use App\Models\User;
use Filament\Actions;
use Filament\Facades\Filament;
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

            ImportAction::make()
                ->icon('heroicon-s-arrow-down-tray')
                ->fields([
                    ImportField::make('house_id')
                        ->label('DD House')
                        ->required()
                        ->mutateBeforeCreate(fn() => Filament::getTenant()?->id)
                        ->rules(['required']),

                    ImportField::make('user_id')
                        ->mutateBeforeCreate(fn($value) => User::firstWhere('phone_number', $value)?->id)
                        ->rules(['required','exists:users,id'])
                        ->label('Assign User'),

                    ImportField::make('supervisor_id')
                        ->mutateBeforeCreate(fn($value) => User::firstWhere('phone_number', $value)?->id)
                        ->rules(['required','exists:users,id'])
                        ->label('Assign Supervisor'),

                    ImportField::make('osrm_code'),

                    ImportField::make('employee_code'),

                    ImportField::make('rso_code')
                        ->required(),

                    ImportField::make('itop_number')
                        ->required(),

                    ImportField::make('pool_number')
                        ->required(),

                    ImportField::make('personal_number')
                        ->required(),

                    ImportField::make('name_as_bank_account')
                        ->label('Name of bank account'),

                    ImportField::make('religion'),

                    ImportField::make('bank_name'),

                    ImportField::make('bank_account_number'),

                    ImportField::make('brunch_name'),

                    ImportField::make('routing_number'),

                    ImportField::make('education'),

                    ImportField::make('blood_group'),

                    ImportField::make('gender'),

                    ImportField::make('present_address'),

                    ImportField::make('permanent_address'),

                    ImportField::make('father_name'),

                    ImportField::make('mother_name'),

                    ImportField::make('market_type'),

                    ImportField::make('salary'),

                    ImportField::make('category'),

                    ImportField::make('agency_name'),

                    ImportField::make('dob')
                        ->rules('date')
                        ->mutateBeforeCreate(function ($value) {
                            // Check if the value is a numeric Excel serial date
                            if (is_numeric($value)) {
                                try {
                                    // Convert Excel serial date to a DateTime object
                                    $excelBaseDate = new \DateTime('1899-12-30'); // Excel's base date (adjusted for MySQL)
                                    $excelBaseDate->modify("+$value days");
                                    return $excelBaseDate->format('Y-m-d'); // Return in MySQL date format
                                } catch (\Exception $e) {
                                    throw new \Exception("Invalid date format for DOB: {$value}");
                                }
                            }
                            // If the value is already in a valid date format (e.g., YYYY-MM-DD), return it
                            return $value;
                        }),

                    ImportField::make('nid'),

                    ImportField::make('division'),

                    ImportField::make('district'),

                    ImportField::make('thana'),

                    ImportField::make('sr_no'),

                    ImportField::make('joining_date')
                        ->required()
                        ->rules('date')
                        ->mutateBeforeCreate(function ($value) {
                            // Check if the value is a numeric Excel serial date
                            if (is_numeric($value)) {
                                try {
                                    // Convert Excel serial date to a DateTime object
                                    $excelBaseDate = new \DateTime('1899-12-30'); // Excel's base date (adjusted for MySQL)
                                    $excelBaseDate->modify("+$value days");
                                    return $excelBaseDate->format('Y-m-d'); // Return in MySQL date format
                                } catch (\Exception $e) {
                                    throw new \Exception("Invalid date format for DOB: {$value}");
                                }
                            }
                            // If the value is already in a valid date format (e.g., YYYY-MM-DD), return it
                            return $value;
                        }),

                ], columns:4)
        ];
    }
}
