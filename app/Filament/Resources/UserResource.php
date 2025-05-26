<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\House;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Group::make()
                    ->columnSpan(2)
                    ->schema([
                        Forms\Components\Section::make('Primary Information')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('phone_number')
                                    ->label('Phone Number')
                                    ->required()
                                    ->numeric()
                                    ->minLength(11)
                                    ->maxLength(11)
                                    ->rule('digits:11')
                                    ->hint(function (Get $get) {
                                        $value = $get('phone_number');

                                        if (!$value || strlen($value) !== 11) {
                                            return new HtmlString('<span class="text-gray-500">Enter a valid 11-digit number</span>');
                                        }

                                        $exists = User::where('phone_number', $value)->exists();

                                        return new HtmlString(
                                            $exists
                                                ? '<span class="text-red-600 font-medium">Not available</span>'
                                                : '<span class="text-green-600 font-medium">Available</span>'
                                        );
                                    })
                                    ->hintIcon('heroicon-o-phone')
                                    ->live(onBlur: true)
                                    ->reactive(),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('password')
                                    ->password()
                                    ->rule(Password::default())
                                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->required(fn (string $context) => $context === 'create')
                                    ->maxLength(255),
                                TextInput::make('password_confirmation')
                                    ->password()
                                    ->requiredWith('password')
                                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                                    ->dehydrated(fn ($state) => filled($state)) // Ignore empty values on update
                                    ->same('password'),
                                Select::make('status')
                                    ->default('active')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                    ]),
                            ]),
                    ]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('User Image')
                            ->schema([
                                FileUpload::make('avatar')
                                    ->label('')
                                    ->disk('public')
                                    ->directory('avatars'),
                            ]),

                        Forms\Components\Section::make('Roles')
                            ->schema([
                                Forms\Components\Select::make('roles')
                                    ->label('')
                                    ->relationship('roles', 'name')
                                    ->saveRelationshipsUsing(function (Model $record, $state) {
                                        $record->roles()->syncWithPivotValues($state, [config('permission.column_names.team_foreign_key') => getPermissionsTeamId()]);
                                    })
                                    ->multiple()
                                    ->preload()
                                    ->searchable(),
                                ]),

                        Forms\Components\Section::make('Attached Houses')
                            ->schema([
                                Select::make('houses')
                                    ->relationship('house', 'code') // Make sure a User model has `houses()` relationship
                                    ->multiple()
                                    ->preload()
                                    ->searchable()
                                    ->label('Attached Houses')
                                    ->saveRelationshipsUsing(function ($record, $state) {
                                        // If no houses are selected, attach the current tenant's house
                                        $houseIds = empty($state) ? [Filament::getTenant()->id] : $state;

                                        $record->house()->sync($houseIds);
                                    })
                            ]),
                    ]),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('house.code')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Str::title($state))
                    ->color('danger'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn ($state) => Str::title($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultPaginationPageOption(5)
            ->filters([
                SelectFilter::make('house')
                    ->label('DD House')
                    ->options(
                        House::where('status', 'active')
                            ->pluck('code', 'id')
                    )
                    ->query(function ($query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('house', function ($q) use ($data) {
                                $q->where('houses.id', $data['value']);
                            });
                        }
                    }),


                SelectFilter::make('role')
                    ->options(
                        Role::pluck('name')
                            ->mapWithKeys(fn($role) => [$role => Str::title($role)])
                            ->toArray()
                    )
                    ->query(function ($query, array $data) {
                        if (!empty($data['value'])) {
                            $userHouses = auth()->user()->house()->pluck('houses.id')->toArray();

                            $query->whereHas('roles', function ($q) use ($data) {
                                $q->where('name', $data['value']);
                            });
                        }
                    }),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
//            'create' => Pages\CreateUser::route('/create'),
//            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('created_at');
    }
}
