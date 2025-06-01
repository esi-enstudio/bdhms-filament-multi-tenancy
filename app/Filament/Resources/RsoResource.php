<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RsoResource\Pages;
use App\Filament\Resources\RsoResource\RelationManagers;
use App\Models\House;
use App\Models\Rso;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RsoResource extends Resource
{
    protected static ?string $model = Rso::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(function (Get $get) {
                        $houseId = Filament::getTenant()?->id;
                        $userId = $get('user_id');

                        $users = collect();

                        if ($houseId) {
                            $users = User::query()
                                ->whereHas('house', fn ($q) => $q->where('houses.id', $houseId))
                                ->whereHas('roles', fn ($q) => $q->where('roles.name', 'rso'))
                                ->where('status', 'active')
                                ->whereNotIn('id', Rso::whereNotNull('user_id')->pluck('user_id'))
                                ->pluck('name', 'id');
                        }

                        if ($userId && !$users->has($userId)) {
                            $user = User::find($userId);
                            if ($user) {
                                $users->put($user->id, $user->name);
                            }
                        }

                        return $users->toArray();
                    })
                    ->required()
                    ->preload()
                    ->searchable()
                    ->disabled(fn () => request()->routeIs('filament.superadmin.resources.rsos.edit')),

                Select::make('supervisor_id')
                    ->label('Supervisor')
                    ->options(function (Get $get) {
                        $houseId = Filament::getTenant()?->id;
                        $supervisorId = $get('supervisor_id');

                        $users = collect();

                        if ($houseId) {
                            $users = User::query()
                                ->whereHas('house', fn ($q) => $q->where('houses.id', $houseId))
                                ->whereHas('roles', fn ($q) => $q->where('roles.name', 'supervisor'))
                                ->where('status', 'active')
                                ->pluck('name', 'id');
                        }

                        if ($supervisorId && !$users->has($supervisorId)) {
                            $user = User::find($supervisorId);
                            if ($user) {
                                $users->put($user->id, $user->name);
                            }
                        }

                        return $users->toArray();
                    })
                    ->required()
                    ->preload()
                    ->searchable()
                    ->disabled(fn () => request()->routeIs('filament.superadmin.resources.rsos.edit')),


                TextInput::make('osrm_code'),
                TextInput::make('employee_code'),
                TextInput::make('rso_code')->required(),
                TextInput::make('itop_number')->numeric()->required(),
                TextInput::make('pool_number')->numeric()->required(),
                TextInput::make('personal_number')->numeric(),
                TextInput::make('name_as_bank_account'),
                TextInput::make('religion'),
                TextInput::make('bank_name'),
                TextInput::make('bank_account_number')->numeric(),
                TextInput::make('brunch_name'),
                TextInput::make('routing_number')->numeric(),
                TextInput::make('education'),
                Select::make('blood_group')
                    ->options([
                        'A+'  => 'A+',
                        'A-'  => 'A-',
                        'B+'  => 'B+',
                        'B-'  => 'B-',
                        'AB+' => 'AB+',
                        'AB-' => 'AB-',
                        'O+'  => 'O+',
                        'O-'  => 'O-',
                    ])
                    ->searchable()
                ,
                Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->default('male')
                    ->required(),
                TextInput::make('present_address'),
                TextInput::make('permanent_address'),
                TextInput::make('father_name'),
                TextInput::make('mother_name'),
                TextInput::make('market_type'),
                TextInput::make('salary')->numeric(),
                TextInput::make('category'),
                TextInput::make('agency_name'),
                DatePicker::make('dob')->native(false),
                TextInput::make('nid')->numeric(),
                TextInput::make('division'),
                TextInput::make('district'),
                TextInput::make('thana'),
                TextInput::make('sr_no'),
                DatePicker::make('joining_date')->native(false),
                DatePicker::make('resign_date')->native(false),
                Select::make('status')
                    ->default('active')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
                TextInput::make('remarks'),
                TextInput::make('document'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('house.code')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('supervisor.name'),
                TextColumn::make('user.name')->label('Name'),
                TextColumn::make('osrm_code')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('employee_code')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('rso_code')
                    ->searchable(),
                TextColumn::make('itop_number')
                    ->searchable(),
                TextColumn::make('pool_number')
                    ->searchable(),
                TextColumn::make('personal_number')
                    ->searchable(),
                TextColumn::make('name_as_bank_account')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('religion')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('bank_name')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('bank_account_number')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('brunch_name')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('routing_number')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('education')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('blood_group')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gender')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('present_address')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('permanent_address')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('father_name')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('mother_name')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('market_type')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('salary')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('category')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('agency_name')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('dob')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nid')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('division')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('district')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('thana')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sr_no')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('joining_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('resign_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->badge()
                    ->color(function ($state){
                        if ($state == "active") {
                            return 'success';
                        }elseif ($state == "inactive") {
                            return 'danger';
                        }

                        return false;
                    })
                    ->formatStateUsing(fn(string $state): string => Str::title($state)),
                TextColumn::make('remarks')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('document')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultPaginationPageOption(5)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRsos::route('/'),
//            'create' => Pages\CreateRso::route('/create'),
//            'edit' => Pages\EditRso::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();
        $rsoIds = Rso::where('supervisor_id', $user->id)->pluck('id');

        return match (true)
        {
            $user->hasRole('super_admin') => $query->latest('created_at'),

            $user->hasRole('rso') => $query->where('user_id', $user->id)->latest('created_at'),

            $user->hasRole('supervisor') => $query->where('supervisor_id', $user->id)->latest('created_at')->orderBy('user_id'),

            default => $query->whereRaw('0=1'),
        };
    }
}
