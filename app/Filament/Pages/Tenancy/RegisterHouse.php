<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\House;
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
            ->schema([
                TextInput::make('name'),
                // ...
            ]);
    }

    protected function handleRegistration(array $data): House
    {
        $house = House::create($data);

        $house->users()->attach(auth()->user());

        return $house;
    }
}
