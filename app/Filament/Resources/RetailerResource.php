<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RetailerResource\Pages;
use App\Filament\Resources\RetailerResource\RelationManagers;
use App\Models\Retailer;
use App\Models\Rso;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RetailerResource extends Resource
{
    protected static ?string $model = Retailer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Attach User')
                    ->options(function (Get $get) {
                        $houseId = Filament::getTenant()?->id;
                        $userId = $get('user_id');

                        $users = collect();

                        if ($houseId) {
                            $users = User::query()
                                ->whereHas('house', fn ($q) => $q->where('houses.id', $houseId))
                                ->whereHas('roles', fn ($q) => $q->where('roles.name', 'retailer'))
                                ->where('status', 'active')
                                ->whereNotIn('id', Retailer::whereNotNull('user_id')->pluck('user_id'))
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
                    ->disabled(fn () => request()->routeIs('filament.superadmin.resources.retailers.edit')),

                Select::make('rso_id')
                    ->label('Attach Rso')
                    ->options(function (Get $get) {
                        $houseId = Filament::getTenant()?->id;

                        return $houseId ? Rso::query()->whereHas('house', fn ($q) => $q->where('houses.id', $houseId))->where('status', 'active')->pluck('itop_number', 'id')->toArray() : '';
                    })
                    ->required()
                    ->preload()
                    ->searchable()
                    ->disabled(fn () => request()->routeIs('filament.superadmin.resources.retailers.edit')),

                Forms\Components\TextInput::make('code')
                    ->maxLength(10),
                Forms\Components\TextInput::make('name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255)
                    ->default('telecom'),
                Forms\Components\TextInput::make('enabled')
                    ->required()
                    ->maxLength(2)
                    ->default('Y'),
                Forms\Components\TextInput::make('sso')
                    ->maxLength(2),
                Forms\Components\TextInput::make('itop_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('service_point')
                    ->maxLength(255),
                Forms\Components\TextInput::make('category')
                    ->maxLength(255),
                Forms\Components\TextInput::make('owner_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('owner_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('division')
                    ->maxLength(255),
                Forms\Components\TextInput::make('district')
                    ->maxLength(255),
                Forms\Components\TextInput::make('thana')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nid')
                    ->numeric()
                    ->maxLength(17),
                Forms\Components\DatePicker::make('dob')
                    ->native(false),
                Forms\Components\TextInput::make('lat')
                    ->numeric()
                    ->maxLength(15),
                Forms\Components\TextInput::make('long')
                    ->numeric()
                    ->maxLength(15),
                Forms\Components\TextInput::make('bts_code')
                    ->maxLength(10),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('remarks')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('house.code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rso.itop_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_rso_code')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('is_bp_code')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('enabled')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sso')
                    ->searchable(),
                Tables\Columns\TextColumn::make('itop_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service_point')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_number')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('division')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('district')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('thana')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('nid')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('dob')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lat')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('long')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('bts_code')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->toggleable(isToggledHiddenByDefault: true)
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
            'index' => Pages\ListRetailers::route('/'),
//            'create' => Pages\CreateRetailer::route('/create'),
//            'edit' => Pages\EditRetailer::route('/{record}/edit'),
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

            $user->hasRole('rso') => $query->where('rso_id', Rso::firstWhere('user_id', $user->id)?->id)->latest('created_at'),

            $user->hasRole('supervisor') => $query->whereIn('rso_id', $rsoIds)->latest('created_at')->orderBy('rso_id'),

            $user->hasRole('retailer') => $query->where('user_id', $user->id)->latest('created_at'),

            default => $query->whereRaw('0=1'),
        };
    }

}
