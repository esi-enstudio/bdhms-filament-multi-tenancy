<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\House;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterHouse extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register house';
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                TextInput::make('code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('cluster'),
                TextInput::make('region'),
                TextInput::make('district'),
                TextInput::make('thana'),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('address'),
                TextInput::make('proprietor_name'),
                TextInput::make('contact_number'),
                TextInput::make('poc_name'),
                TextInput::make('poc_number'),
                DatePicker::make('lifting_date')->required()->native(false),
                Select::make('status')
                    ->required()
                    ->default('active')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
                TextInput::make('remarks'),
            ]);
    }

    protected function handleRegistration(array $data): House
    {
        $house = House::create($data);

        $house->users()->attach(auth()->user());

        return $house;
    }
}
